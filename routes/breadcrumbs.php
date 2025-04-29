<?php // routes/breadcrumbs.php

// Note: Laravel will automatically resolve `Breadcrumbs::` without
// this import. This is nice for IDE syntax and refactoring.

use App\Models\EmailService\EmailProvider;
use App\Models\Subscription\SubscriptionPlan;
use App\Models\Subscription\SubscriptionPlanFeature;
use App\Models\User;

// This import is also not required, and you could replace `BreadcrumbTrail $trail`
//  with `$trail`. This is nice for IDE type checking and completion.
use Spatie\Permission\Models\Role;
use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;

// Dashboard as Home
Breadcrumbs::for('dashboard', function (BreadcrumbTrail $trail) {
    $trail->push(__('pageTitle.custom.home'), route('dashboard'));
});

// Settings
Breadcrumbs::for('settings', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push(__('breadcrumb.custom.configuration.parentInfo'), route('configurations.details'));
});

// Settings - Basic Info
Breadcrumbs::for('settingsBasicInfo', function (BreadcrumbTrail $trail) {
    $trail->parent('settings');
    $trail->push(__('breadcrumb.custom.configuration.childInfo.basicInfo'), route('configurations.basicInfo'));
});

// Settings - Additional Info
Breadcrumbs::for('settingsAdditionalInfo', function (BreadcrumbTrail $trail) {
    $trail->parent('settings');
    $trail->push(__('breadcrumb.custom.configuration.childInfo.additionalInfo'), route('configurations.additionalInfo'));;
});

// Settings - Contact Info
Breadcrumbs::for('settingsContactInfo', function (BreadcrumbTrail $trail) {
    $trail->parent('settings');
    $trail->push(__('breadcrumb.custom.configuration.childInfo.contactInfo'), route('configurations.contactInfo'));
});

// Settings - Global Info
Breadcrumbs::for('settingsGlobalInfo', function (BreadcrumbTrail $trail) {
    $trail->parent('settings');
    $trail->push(__('breadcrumb.custom.configuration.childInfo.globalInfo'), route('configurations.globalInfo'));
});

// User Management Menu
Breadcrumbs::for('userManagement', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push(__('breadcrumb.custom.user.parentInfo'));
});

// Roles
Breadcrumbs::for('roles', function (BreadcrumbTrail $trail) {
    $trail->parent('userManagement');
    $trail->push(__('breadcrumb.custom.role.childInfo.index'), route('roles.index'));
});

// Add Roles
Breadcrumbs::for('addRole', function (BreadcrumbTrail $trail) {
    $trail->parent('roles');
    $trail->push(__('breadcrumb.custom.role.childInfo.create'), route('roles.create'));
});

// Edit Roles
Breadcrumbs::for('editRole', function (BreadcrumbTrail $trail, Role $role) {
    $trail->parent('roles');
    $trail->push(__('breadcrumb.custom.role.childInfo.edit'), route('roles.edit', $role));
});

// Roles Details
Breadcrumbs::for('roleDetails', function (BreadcrumbTrail $trail, Role $role) {
    $trail->parent('roles');
    $trail->push(__('breadcrumb.custom.role.childInfo.details'), route('roles.show', $role));
});

// User List
Breadcrumbs::for('users', function (BreadcrumbTrail $trail) {
    $trail->parent('userManagement');
    $trail->push(__('breadcrumb.custom.user.childInfo.index'), route('users.index'));
});

// Add User
Breadcrumbs::for('addUser', function (BreadcrumbTrail $trail) {
    $trail->parent('users');
    $trail->push(__('breadcrumb.custom.user.childInfo.create'), route('users.create'));
});

// Edit User
Breadcrumbs::for('editUser', function (BreadcrumbTrail $trail, User $user) {
    $trail->parent('users');
    $trail->push(__('breadcrumb.custom.user.childInfo.edit'), route('users.edit', $user));
});

// User Details
Breadcrumbs::for('userDetails', function (BreadcrumbTrail $trail, User $user) {
    $trail->parent('users');
    $trail->push(__('breadcrumb.custom.user.childInfo.details'), route('users.show', $user));
});

// My Profile
Breadcrumbs::for('myProfile', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push(__('breadcrumb.custom.user.childInfo.profile'), route('profile.edit'));
});

// Companies
Breadcrumbs::for('companies', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Company List', route('companies.index'));
});

// Subscription
Breadcrumbs::for('subscription', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Subscription', route('subscription-plans.index'));
});

// Subscription Plan List
Breadcrumbs::for('subscriptionPlans', function (BreadcrumbTrail $trail) {
    $trail->parent('subscription');
    $trail->push('Subscription Plan List', route('subscription-plans.index'));
});

// Add Subscription Plan
Breadcrumbs::for('addSubscriptionPlan', function (BreadcrumbTrail $trail) {
    $trail->parent('subscriptionPlans');
    $trail->push('Add', route('subscription-plans.create'));
});

// Edit Subscription Plan
Breadcrumbs::for('editSubscriptionPlan', function (BreadcrumbTrail $trail, SubscriptionPlan $subscriptionPlan) {
    $trail->parent('subscriptionPlans');
    $trail->push('Edit', route('subscription-plans.edit', $subscriptionPlan));
});

// Subscription Plan Details
Breadcrumbs::for('subscriptionPlanDetails', function (BreadcrumbTrail $trail, SubscriptionPlan $subscriptionPlan) {
    $trail->parent('subscriptionPlans');
    $trail->push('Details', route('subscription-plans.show', $subscriptionPlan));
});

// Subscription Plan Feature List
Breadcrumbs::for('subscriptionPlanFeatures', function (BreadcrumbTrail $trail) {
    $trail->parent('subscription');
    $trail->push('Subscription Plan Feature List', route('subscription-plan-features.index'));
});

// Add Subscription Plan Feature
Breadcrumbs::for('addSubscriptionPlanFeature', function (BreadcrumbTrail $trail) {
    $trail->parent('subscriptionPlanFeatures');
    $trail->push('Add', route('subscription-plan-features.create'));
});

// Edit Subscription Plan Feature
Breadcrumbs::for('editSubscriptionPlanFeature', function (BreadcrumbTrail $trail, SubscriptionPlanFeature $subscriptionPlanFeature) {
    $trail->parent('subscriptionPlanFeatures');
    $trail->push('Edit', route('subscription-plan-features.edit', $subscriptionPlanFeature));
});

// Email Provider List
Breadcrumbs::for('emailProviders', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Email Provider List', route('email-providers.index'));
});

// Add Email Provider
Breadcrumbs::for('addEmailProvider', function (BreadcrumbTrail $trail) {
    $trail->parent('emailProviders');
    $trail->push('Add', route('email-providers.create'));
});

// Edit Email Provider
Breadcrumbs::for('editEmailProvider', function (BreadcrumbTrail $trail, EmailProvider $emailProvider) {
    $trail->parent('emailProviders');
    $trail->push('Edit', route('email-providers.edit', $emailProvider));
});



