<?php

namespace App\Services\Subscription;

use App\Services\BaseModelService;
use Illuminate\Support\Facades\DB;
use App\Services\Company\CompanyService;
use App\Services\APIService\HRM\HRMService;
use App\Models\Subscription\SubscriptionPlan;

class SubscriptionPlanService extends BaseModelService
{
    private bool $isSync = true;
    private HRMService $hrmService;
    private CompanyService $companyService;

    public function __construct(HRMService $hrmService, CompanyService $companyService)
    {
        $this->hrmService = $hrmService;
        $this->companyService = $companyService;
    }
    public function model(): string
    {
        return SubscriptionPlan::class;
    }

    public function getSubscriptionPlans()
    {
        return $this->model()::with('subscriptionPlanFeatures')->get();
    }

    public function getActiveSubscriptionPlans()
    {
        return $this->model()::where('is_active', true)->with('subscriptionPlanFeatures')->get();
    }

    public function getSubscriptionPlanDetails(SubscriptionPlan $subscriptionPlan)
    {
        return $subscriptionPlan->load('subscriptionPlanFeatures');
    }

    public function updateOrCreate($data)
    {
        $data["slug"] = $this->generateSlug($data["name"]);
        $subscriptionPlan = $this->model()::updateOrCreate(["slug" => $data["slug"]], $data);
        if ($this->isSync) {
            $data = [
                "name" => $subscriptionPlan->name,
                "slug" => $subscriptionPlan->slug,
                "description" => $subscriptionPlan->description,
                "price" => $subscriptionPlan->price,
                "plan_type" => $subscriptionPlan->plan_type,
                "duration" => $subscriptionPlan->duration,
                "duration_unit" => $subscriptionPlan->duration_unit,
                "trial_duration" => $subscriptionPlan->trial_duration,
                "trial_duration_unit" => $subscriptionPlan->trial_duration_unit,
                "discount_amount" => $subscriptionPlan->discount_amount,
                "note" => $subscriptionPlan->note,
                "is_active" => "0",
            ];
            $this->hrmService->syncSubscriptionPlansForCompanies($data);
        }
        return $subscriptionPlan;

    }

    public function changeStatus(SubscriptionPlan $subscriptionPlan, $isActive)
    {
        $isActive = ($isActive == true) ? false : true;
        $subscriptionPlan->update(['is_active' => $isActive]);
        return $subscriptionPlan;
    }

    public function featuresUpdate(SubscriptionPlan $subscriptionPlan, $validatedData)
    {
        if (!array_key_exists('subscription_plan_features', $validatedData)) {
            return false;
        }

        $subscriptionPlan->subscriptionPlanFeatures()->sync($validatedData['subscription_plan_features']);
        return $subscriptionPlan;
    }

    public function syncSubscriptionPlans($company)
    {
        $subscriptionPlans = $this->model()::with('subscriptionPlanFeatures:id')->get();
        $this->hrmService->syncSubscriptionPlans($subscriptionPlans, $company);
    }

    public function syncSubscriptionPlanAcrossCompanies(SubscriptionPlan $subscriptionPlan)
    {
        $companies = $this->companyService->getCompanies();
        foreach($companies as $company) {
            $this->hrmService->syncSubscriptionPlans($subscriptionPlan, $company);
        }
    }
}
