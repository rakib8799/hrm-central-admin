<?php

namespace App\Http\Controllers\EmailService;

use Exception;
use Inertia\Inertia;
use App\Constants\Constants;
use Illuminate\Http\Request;
use App\Services\HelperService;
use App\Http\Controllers\Controller;
use Diglactic\Breadcrumbs\Breadcrumbs;
use Illuminate\Support\Facades\Redirect;
use App\Models\EmailService\EmailProvider;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;
use App\Services\EmailService\EmailProviderService;
use App\Http\Requests\EmailService\CreateEmailProviderRequest;
use App\Http\Requests\EmailService\UpdateEmailProviderRequest;

class EmailProviderController extends Controller implements HasMiddleware
{
    protected EmailProviderService $emailProviderService;

    public function __construct(EmailProviderService $emailProviderService)
    {
        $this->emailProviderService = $emailProviderService;
    }

    public static function middleware(): array
    {
        return [
            new Middleware('permission:can-create-email-provider', only: ['create', 'store']),
            new Middleware('permission:can-edit-email-provider', only: ['edit', 'update', 'changeStatus']),
            new Middleware('permission:can-view-email-provider', only: ['index']),
            new Middleware('permission:can-view-details-email-provider', only: ['show']),
        ];
    }

    public function index()
    {
        $emailProviders = $this->emailProviderService->getEmailProviders();
        $breadcrumbs = Breadcrumbs::generate('emailProviders');
        $responseData = [
            'emailProviders' => $emailProviders,
            'breadcrumbs' => $breadcrumbs,
            'pageTitle' => 'Email Provider List',
        ];

        return Inertia::render('EmailService/EmailProvider/Index', $responseData);
    }

    public function create()
    {
        $breadcrumbs = Breadcrumbs::generate('addEmailProvider');
        $responseData = [
            'breadcrumbs' => $breadcrumbs,
            'pageTitle' => 'Add Email Provider',
        ];
        return Inertia::render('EmailService/EmailProvider/Create', $responseData);
    }

    public function store(CreateEmailProviderRequest $request)
    {
        $validatedData = $request->validated();
        $emailProvider = $this->emailProviderService->createEmailProvider($validatedData);
        if ($emailProvider) {
            try {
                $this->emailProviderService->syncEmailProviderAcrossCompanies($emailProvider);
            } catch (Exception $e) {
                HelperService::captureException($e);
            }
        }

        $status = $emailProvider ? Constants::SUCCESS : Constants::ERROR;
        $message = $emailProvider ? 'Email Provider created successfully' : 'Email Provider could not be created';
        return Redirect::route('email-providers.index')->with($status, $message);
    }

    public function edit(EmailProvider $emailProvider)
    {
        $breadcrumbs = Breadcrumbs::generate('editEmailProvider', $emailProvider);
        $responseData = [
            'emailProvider' => $emailProvider,
            'breadcrumbs' => $breadcrumbs,
            'pageTitle' => 'Edit Email Provider',
        ];
        return Inertia::render('EmailService/EmailProvider/Create', $responseData);
    }

    public function update(UpdateEmailProviderRequest $request, EmailProvider $emailProvider)
    {
        $validatedData = $request->validated();
        $isUpdated = $this->emailProviderService->update($emailProvider, $validatedData);
        if ($isUpdated) {
            try {
                $this->emailProviderService->syncEmailProviderAcrossCompanies($emailProvider);
            } catch (Exception $e) {
                HelperService::captureException($e);
            }
        }
        
        $status = $isUpdated ? Constants::SUCCESS : Constants::ERROR;
        $message = $isUpdated ? 'Email Provider updated successfully' : 'Email Provider could not be updated';
        return Redirect::route('email-providers.index')->with($status, $message);
    }

    public function changeStatus(Request $request, EmailProvider $emailProvider)
    {
        $isAnyActiveEmailProvider = $this->emailProviderService->getActiveEmailProvider();
        if ($request->is_active == true && ($isAnyActiveEmailProvider &&$isAnyActiveEmailProvider->id === $emailProvider->id)) {
            $status = Constants::ERROR;
            $message = 'You can not deactivate all email providers';
        } else {
            $emailProvider = $this->emailProviderService->changeStatus($emailProvider, $request->is_active);
            if ($emailProvider) {
                try {
                    $this->emailProviderService->syncEmailProviderAcrossCompanies($emailProvider);
                } catch (Exception $e) {
                    HelperService::captureException($e);
                }
            }

            $status = Constants::SUCCESS;
            $message = $emailProvider->is_active ? 'Email Provider is activated' : 'Email Provider is deactivated';
        }
        return Redirect::back()->with($status, $message);
    }
}
