<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use Diglactic\Breadcrumbs\Breadcrumbs;
use App\Services\Company\CompanyService;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class CompanyController extends Controller implements HasMiddleware
{
    protected CompanyService $companyService;

    public function __construct(CompanyService $companyService)
    {
        $this->companyService = $companyService;
    }

    public static function middleware(): array
    {
        return [
            new Middleware('permission:can-edit-company', only: ['changeStatus']),
            new Middleware('permission:can-view-company', only: ['index']),
            new Middleware('permission:can-view-details-company', only: ['show']),
        ];
    }

    public function index()
    {
        $company = $this->companyService->getCompanyDetails();
        $breadcrumbs = Breadcrumbs::generate('companies', $company);
        $responseData = [
            'company' => $company,
            'breadcrumbs' => $breadcrumbs,
            'pageTitle' => "Company List"
        ];
        return Inertia::render('Company/index', $responseData);
    }
}
