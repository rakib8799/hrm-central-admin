<?php

namespace App\Http\Controllers\API;

use App\Models\Company\Company;
use App\Services\HelperService;
use App\Services\TenantService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Services\Company\CompanyService;
use App\Services\DatabaseManagementService;
use App\Services\EmailService\EmailEventService;
use App\Services\Subscription\SubscriptionService;
use App\Http\Requests\Company\CompanyCreateRequest;
use App\Http\Requests\Company\CompanyUpdateRequest;
use App\Services\EmailService\EmailProviderService;
use App\Services\Company\CompanyOnboardingStepService;
use App\Services\Subscription\SubscriptionPlanService;
use App\Services\APIService\HRM\HRMTenantCreateService;
use App\Services\Subscription\SubscriptionPlanFeatureService;

class CompanyController extends Controller
{
    private CompanyService $companyService;
    private SubscriptionPlanService $subscriptionPlanService;
    private EmailEventService $emailEventService;
    private EmailProviderService $emailProviderService;
    private DatabaseManagementService $databaseManagementService;
    private CompanyOnboardingStepService $companyOnboardingStepService;
    private HRMTenantCreateService $hrmTenantCreateService;
    private TenantService $tenantService;
    private SubscriptionService $subscriptionService;
    private SubscriptionPlanFeatureService $subscriptionPlanFeatureService;

    public function __construct(
        CompanyService $companyService,
        SubscriptionPlanService $subscriptionPlanService,
        EmailEventService $emailEventService,
        EmailProviderService $emailProviderService,
        DatabaseManagementService $databaseManagementService,
        CompanyOnboardingStepService $companyOnboardingStepService,
        TenantService                $tenantService,
        HRMTenantCreateService $hrmTenantCreateService,
        SubscriptionService $subscriptionService,
        SubscriptionPlanFeatureService $subscriptionPlanFeatureService
    )
    {
        $this->companyService = $companyService;
        $this->subscriptionPlanService = $subscriptionPlanService;
        $this->emailEventService = $emailEventService;
        $this->emailProviderService = $emailProviderService;
        $this->databaseManagementService = $databaseManagementService;
        $this->companyOnboardingStepService = $companyOnboardingStepService;
        $this->tenantService = $tenantService;
        $this->hrmTenantCreateService = $hrmTenantCreateService;
        $this->subscriptionService = $subscriptionService;
        $this->subscriptionPlanFeatureService = $subscriptionPlanFeatureService;
    }


    public function store(CompanyCreateRequest $companyCreateRequest): JsonResponse
    {
        $this->companyService->createCompany($companyCreateRequest->validated());
        return response()->json([
            'message' => 'Company created successfully'
        ]);
    }

    public function update(CompanyUpdateRequest $companyUpdateRequest, Company $company): JsonResponse
    {
        $company = $this->companyService->updateCompany($company, $companyUpdateRequest->validated());
        $this->tenantService->updateTenant($company);
        return response()->json([
            'message' => 'Company updated successfully'
        ]);
    }

    public function onboarding(CompanyCreateRequest $companyCreateRequest): JsonResponse
    {
        $validatedData = $companyCreateRequest->validated();

        # create company
        $company = $this->companyService->createCompany($validatedData);

        # create subscription and subscription history
        $subscription = $this->subscriptionService->createSubscription($company, $validatedData['subscription_plan_id']);

        # create tenant
        $this->tenantService->createTenant($company);
        $onboardStepData = [
            'company_id' => $company->id,
            'company_created' => true
        ];
        $this->companyOnboardingStepService->updateOnboardingStep($company, $onboardStepData);

        $validatedDatabaseData = $this->databaseManagementService->createTenantDatabase($company->workspace);
        $this->tenantService->createTenantDatabase($company, $validatedDatabaseData);
        $onboardingStepData = [
            'company_id' => $company->id,
            'database_created' => true
        ];
        $this->companyOnboardingStepService->updateOnboardingStep($company, $onboardingStepData);

        $this->hrmTenantCreateService->databaseMigration($company);
        $onboardingStepData = [
            'company_id' => $company->id,
            'database_migrated' => true
        ];
        $this->companyOnboardingStepService->updateOnboardingStep($company, $onboardingStepData);

        # initial data load
        $this->hrmTenantCreateService->initialDataLoad($company);
        $onboardingStepData = [
            'company_id' => $company->id,
            'initial_data_loaded' => true
        ];
        $this->companyOnboardingStepService->updateOnboardingStep($company, $onboardingStepData);

        # create admin user
        $password = $validatedData['password'] ?? null;
        if ($password === null) {
            $password = $this->databaseManagementService->generatePassword();
        }
        $userCreateData = [
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => $password,
            'workspace' => $company->workspace
        ];
        unset($validatedData['password']);
        $response = $this->hrmTenantCreateService->createAdminUser($company, $userCreateData);
        $onboardingStepData = [
            'company_id' => $company->id,
            'user_created' => true
        ];
        $this->companyOnboardingStepService->updateOnboardingStep($company, $onboardingStepData);
        $emailVerificationData = [
            'email_verification_url' => $response['email_verification_url']
        ];

        $this->companyService->sendCompanyEmailVerification($company, $emailVerificationData);
        Log::info('Email verification sent.');

        $this->subscriptionPlanFeatureService->syncSubscriptionPlanFeatures($company);
        Log::info('Subscription plan features synced.');

        $this->subscriptionPlanService->syncSubscriptionPlans($company);
        Log::info('Subscription plans synced.');

        $this->subscriptionService->syncSubscription($company, $subscription);
        Log::info('Subscription synced.');

        $this->emailEventService->syncEmailEvents($company);
        Log::info('Email events synced.');

        $this->emailProviderService->syncEmailProviders($company);
        Log::info('Email providers synced.');

        # $this->emailEventTemplateService->syncEmailEventTemplates($company);
        try {
            Log::info('All sync operations completed successfully.');
            return response()->json([
                'message' => 'Company created successfully'
            ]);
        } catch (\Exception $e) {
            HelperService::captureException($e);
            Log::error('Error occurred: ' . $e->getMessage());
            Log::error($e->getTraceAsString());
            return response()->json(['error' => 'An error occurred'], 500);
        }

    }
}

