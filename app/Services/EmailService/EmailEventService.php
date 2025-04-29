<?php

namespace App\Services\EmailService;


use App\Models\EmailService\EmailEvent;
use App\Services\BaseModelService;
use App\Services\APIService\HRM\HRMService;

class EmailEventService extends BaseModelService
{
    private bool $isSync = true;
    private HRMService $hrmService;

    public function __construct(HRMService $hrmService)
    {
        $this->hrmService = $hrmService;
    }

    public function model(): string
    {
        return EmailEvent::class;
    }

    public function createEmailEvent($data)
    {
        $data['slug'] = $this->generateSlug($data['name']);
        $instance =  $this->create($data);
        if ($this->isSync) {
            $data = [
                "name" => $instance->name,
                "slug" => $instance->slug,
            ];
            $this->hrmService->syncEmailEventsForCompanies($data);
        }
        return $instance;
    }

    public function SyncEmailEvents($company)
    {
        $emailEvents = $this->model()::all();
        foreach ($emailEvents as $emailEvent) {
            $data = [
                "name" => $emailEvent->name,
                "slug" => $emailEvent->slug,
            ];
            $this->hrmService->syncEmailEvents($data, $company);
        }
    }
}
