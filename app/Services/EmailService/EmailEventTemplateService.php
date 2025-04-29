<?php

namespace App\Services\EmailService;


use App\Models\EmailService\EmailEventTemplate;
use App\Services\BaseModelService;
use App\Services\APIService\HRM\HRMService;

class EmailEventTemplateService extends BaseModelService
{
    private bool $isSync = true;
    private HRMService $hrmService;

    public function __construct(HRMService $hrmService)
    {
        $this->hrmService = $hrmService;
    }
    public function model(): string
    {
        return EmailEventTemplate::class;
    }

    public function createEmailEventTemplate($data)
    {
        $instance = $this->create($data);
        if($this->isSync){
            $data = [
                "email_event_id" => $instance->email_event_id,
                "email_provider_id" => $instance->email_provider_id,
                "template_id" => $instance->template_id,
            ];
            $this->hrmService->syncEmailEventTemplatesForCompanies($data);
        }
    }


    public function SyncEmailEventTemplates($company)
    {
        $emailEventTemplates = $this->model()::all();
        foreach ($emailEventTemplates as $emailEventTemplate) {
            $data = [
                "email_event_id" => $emailEventTemplate->email_event_id,
                "email_provider_id" => $emailEventTemplate->email_provider_id,
                "template_id" => $emailEventTemplate->template_id,
            ];
            $this->hrmService->syncEmailEventTemplates($data, $company);
        }
    }
}
