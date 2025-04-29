<?php

namespace App\Services\Subscription;

use App\Services\BaseModelService;
use Illuminate\Support\Facades\DB;
use App\Services\Company\CompanyService;
use App\Services\APIService\HRM\HRMService;
use App\Models\Subscription\SubscriptionPlanFeature;

class SubscriptionPlanFeatureService extends BaseModelService
{
    protected HRMService $hrmService;
    protected CompanyService $companyService;

    public function __construct(HRMService $hrmService, CompanyService $companyService)
    {
        $this->hrmService = $hrmService;
        $this->companyService = $companyService;
    }

    public function model(): string
    {
        return SubscriptionPlanFeature::class;
    }

    public function getSubscriptionPlanFeatures()
    {
        return $this->model()::all();
    }

    public function getActiveSubscriptionPlanFeatures()
    {
        return $this->model()::where('is_active', true)->get();
    }

    public function changeStatus(SubscriptionPlanFeature $subscriptionPlanFeature, $isActive)
    {
        $result = DB::transaction( function () use ($subscriptionPlanFeature, $isActive) {
            $isActive = ($isActive == true) ? false : true;
            $subscriptionPlanFeature->update(['is_active' => $isActive]);
            
            if($subscriptionPlanFeature->is_active == false) {
                $subscriptionPlanFeature->subscriptionPlans()->detach();
            }

            return $subscriptionPlanFeature;
        });
        return $result;
    }

    // API methods
    public function syncSubscriptionPlanFeatures($company)
    {
        $subscriptionPlanFeatures = $this->getSubscriptionPlanFeatures();
        $this->hrmService->syncSubscriptionPlanFeatures($subscriptionPlanFeatures, $company);
    }

    public function syncSubscriptionPlanFeatureAcrossCompanies(SubscriptionPlanFeature $subscriptionPlanFeature)
    {
        $companies = $this->companyService->getCompanies();
        foreach($companies as $company) {
            $this->hrmService->syncSubscriptionPlanFeatures($subscriptionPlanFeature, $company);
        }
    }
}
