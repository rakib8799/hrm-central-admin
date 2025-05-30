<?php

use App\Http\Controllers\CompanyController;
use App\Http\Controllers\EmailService\EmailProviderController;
use App\Http\Controllers\Subscription\SubscriptionPlanController;
use Inertia\Inertia;
use App\Http\Middleware\Language;
use Illuminate\Support\Facades\Route;
use Diglactic\Breadcrumbs\Breadcrumbs;
use Illuminate\Foundation\Application;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\LocalizationController;
use App\Http\Controllers\ConfigurationController;
use App\Http\Controllers\Permission\RoleController;
use App\Http\Controllers\Subscription\SubscriptionPlanFeatureController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/localization/{locale}', [LocalizationController::class, 'localization'])->name('localization');
Route::get('/language-options', [LanguageController::class, 'getLanguageOptions'])->name('getLanguageOptions');


Route::middleware(Language::class)
    ->group(function () {

    Route::get('/', function () {
        return Inertia::render('Auth/Login', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'laravelVersion' => Application::VERSION,
            'phpVersion' => PHP_VERSION,
            'pageTitle' => __('pageTitle.custom.login'),
        ]);
    })->middleware('guest');

    Route::get('/dashboard', function () {
        $breadcrumbs = Breadcrumbs::generate('dashboard');
        $permissions = session('permissions');
        $response = [
            'breadcrumbs' => $breadcrumbs,
            'pageTitle' => __('pageTitle.custom.home'),
            'permissions' => $permissions
        ];
        return Inertia::render('Dashboard', $response);
    })->middleware(['auth', 'verified'])->name('dashboard');

    Route::middleware('auth')->group(function () {
        // Profile related routes
        Route::prefix('profile')->group(function() {
            Route::get('/', [ProfileController::class, 'edit'])->name('profile.edit');
            Route::patch('/', [ProfileController::class, 'update'])->name('profile.update');
            Route::delete('/', [ProfileController::class, 'destroy'])->name('profile.destroy');
        });

        // Configuration related routes
        Route::prefix('configurations')->group(function() {
            Route::get('/', [ConfigurationController::class, 'details'])->name('configurations.details');
            Route::get('basic-info', [ConfigurationController::class, 'basicInfo'])->name('configurations.basicInfo');
            Route::get('additional-info', [ConfigurationController::class, 'additionalInfo'])->name('configurations.additionalInfo');
            Route::get('contact-info', [ConfigurationController::class, 'contactInfo'])->name('configurations.contactInfo');
            Route::get('global-info', [ConfigurationController::class, 'globalInfo'])->name('configurations.globalInfo');

            Route::patch('basic-info', [ConfigurationController::class, 'updateBasicInfo'])->name('configurations.updateBasicInfo');
            Route::patch('additional-info', [ConfigurationController::class, 'updateAdditionalInfo'])->name('configurations.updateAdditionalInfo');
            Route::patch('contact-info', [ConfigurationController::class, 'updateContactInfo'])->name('configurations.updateContactInfo');
            Route::patch('global-info', [ConfigurationController::class, 'updateGlobalInfo'])->name('configurations.updateGlobalInfo');
        });

        // Roles related routes
        Route::resource('roles', RoleController::class);
        Route::post('assign-permission', [RoleController::class, 'assignPermissionToRole']);
        Route::delete('remove-assigned-permission', [RoleController::class, 'removePermissionFromRole']);
        Route::prefix('roles/{role}')->group(function() {
            Route::patch('change-status', [RoleController::class, 'changeStatus'])->name('roles.changeStatus');
            Route::delete('remove-user/{user}', [RoleController::class, 'removeUserFromRole'])->name('roles.removeUserFromRole');
        });

        // User related routes
        Route::resource('/users', UserController::class);
        Route::prefix('users/{user}')->group(function() {
            Route::patch('update-details', [UserController::class, 'updateDetails'])->name('users.updateDetails');
            Route::patch('update-email', [UserController::class, 'updateEmail'])->name('users.updateEmail');
            Route::patch('update-roles', [UserController::class, 'updateRoles'])->name('users.updateRoles');
            Route::patch('update-password', [UserController::class, 'updatePassword'])->name('users.updatePassword');
            Route::patch('change-status', [UserController::class, 'changeStatus'])->name('users.changeStatus');
        });

        // Company related routes
        Route::prefix('companies')->group(function() {
            Route::get('/', [CompanyController::class, 'index'])->name('companies.index');
            Route::get('/{company}', [CompanyController::class, 'show'])->name('companies.show');
        });

        // Subscription plan related routes
        Route::resource('/subscription-plans', SubscriptionPlanController::class);
        Route::prefix('subscription-plans/{subscription_plan}')->group(function() {
            Route::patch('change-status', [SubscriptionPlanController::class, 'changeStatus'])->name('subscription-plans.changeStatus');
            Route::patch('features', [SubscriptionPlanController::class, 'featuresUpdate'])->name('subscription-plans.featuresUpdate');
        });

        // Subscription plan feature related routes
        Route::resource('/subscription-plan-features', SubscriptionPlanFeatureController::class);
        Route::prefix('subscription-plan-features/{subscription_plan_feature}')->group(function() {
            Route::patch('change-status', [SubscriptionPlanFeatureController::class, 'changeStatus'])->name('subscription-plan-features.changeStatus');
        });

        // Email Providers related routes
        Route::resource('/email-providers', EmailProviderController::class);
        Route::patch('email-providers/{email_provider}/change-status', [EmailProviderController::class, 'changeStatus'])->name('email-providers.changeStatus');
    });
});


require __DIR__ . '/auth.php';

