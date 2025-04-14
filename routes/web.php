<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoutingController;
use App\Http\Controllers\IndividualUserController;
use App\Http\Controllers\CompanyUserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LockedScreenController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\Users\CompanySubUserController;
use App\Http\Controllers\Users\CompanyUserProfileController;
use App\Http\Controllers\Users\CompanyPartnersController;
use App\Http\Controllers\Users\CompanyUserCategoriesController;
use App\Http\Controllers\Newsletters\CompanyNewsLetterController;
use App\Http\Controllers\CRM\CustomerManagment;
use App\Http\Controllers\CRM\EmailManagement;
use App\Http\Controllers\CRM\CampaignController;
use App\Http\Controllers\CRM\ActivityController;
use App\Models\Campaign;
use App\Http\Controllers\CRM\ContractController;

// Load authentication routes
require __DIR__ . '/auth.php';

// Public Routes - Accessible without authentication
// -----------------------------------------------
// Welcome/Landing page route
Route::get('/', [WelcomeController::class, 'index'])->name('root');

// Route to grant access when "Get Started" is clicked
// This sets the access_granted session and allows navigation to auth pages
Route::get('/start', [WelcomeController::class, 'grantAccess'])->name('start');

// Authentication and Registration Routes
// ------------------------------------
// Routes for handling user registration
Route::post('/register/individual', [IndividualUserController::class, 'register']);
Route::post('/register/company',    [CompanyUserController::class, 'register'])->name('register.company.store');


// Routes for OTP and token verification
Route::post('/request-otp',         [AuthController::class, 'requestOtp'])->name('auth.otp.request');
Route::get('/resend-otp',          [AuthController::class, 'resendOtp'])->name('auth.otp.resend');
Route::post('/auth/verify-token',   [AuthController::class, 'verifyToken'])->name('auth.verify.token');
Route::post('/verify-otp',          [AuthController::class, 'verifyOtp'])->name('auth.otp.verify');

// Lock Screen Routes
// ----------------
Route::post('/lock-screen',         [LockedScreenController::class, 'verifyPin'])->name('verify-pin');
Route::get('/lock-screen',          [LockedScreenController::class, 'showLockScreen'])->name('lock-screen');
Route::get('/lock-screen/logout',   [LockedScreenController::class, 'logout'])->name('lock.logout');

// Protected Routes - Require proper navigation through "Get Started"
// --------------------------------------------------------------
Route::group(['middleware' => ['prevent.direct.access']], function () {
    // Authentication view routes - Protected from direct URL access
    Route::get('/auth',            function () {
        return view('authentications.auth');
    })->name('auth.auth');
    Route::get('/auth/company',    function () {
        return view('authentications.company');
    })->name('auth.company');
    Route::get('/auth/individual', function () {
        return view('authentications.individual');
    })->name('auth.individual');
    Route::get('/auth/login',      function () {
        return view('authentications.login');
    })->name('auth.login');
    Route::get('/auth/token',      function () {
        return view('authentications.token');
    })->name('auth.token');
});

// Routes protected by authentication middleware
Route::group(['middleware' => 'auth'], function () {
    Route::get('/home', function () {
        return view('index');
    })->name('home');

    // Company Sub Users Management Routes
    Route::prefix('company')->name('company-sub-users.')->group(function () {
        Route::get('/users',                                     [CompanySubUserController::class, 'index'])->name('index');
        Route::get('/users/create',                              [CompanySubUserController::class, 'create'])->name('create');
        Route::post('/users',                                    [CompanySubUserController::class, 'store'])->name('store');
        Route::get('/users/{companySubUser}/edit',               [CompanySubUserController::class, 'edit'])->name('edit');
        Route::put('/users/{companySubUser}',                    [CompanySubUserController::class, 'update'])->name('update');
        Route::delete('/users/{companySubUser}',                 [CompanySubUserController::class, 'destroy'])->name('destroy');
        Route::put('/users/{companySubUser}/toggle-lock',        [CompanySubUserController::class, 'toggleLock'])->name('toggle-lock');
        Route::post('/users/{companySubUser}/reset-password',    [CompanySubUserController::class, 'resetPassword'])->name('reset-password');
        Route::get('/users/{companySubUser}/get-pin',            [CompanySubUserController::class, 'getPin'])->name('get-pin');
        Route::post('/users/{companySubUser}/send-sms',          [CompanySubUserController::class, 'sendSms'])->name('send-sms');
        Route::get('sub-users/data',                             [CompanySubUserController::class, 'getData'])->name('data');
        Route::post('/users/bulk-upload',                        [CompanySubUserController::class, 'bulkUpload'])->name('bulk-upload');
        Route::get('/users/download-template',                   [CompanySubUserController::class, 'downloadTemplate'])->name('download-template');
        Route::post('/users/{companySubUser}/send-email',        [CompanySubUserController::class, 'sendEmail'])->name('send-email');
    });


    // User Profile Management Routes
    Route::prefix('company')->name('company.')->group(function () {
        // Sub-user profile management routes (more specific routes first)
        Route::get('user-profiles/sub-users',                      [CompanyUserProfileController::class, 'getSubUsers'])->name('user-profiles.sub-users');
        Route::post('user-profiles/sub-users/{userId}/assign',     [CompanyUserProfileController::class, 'assignProfile'])->name('user-profiles.assign-profile');
        Route::get('user-profiles/sub-users/{userId}/menu-access', [CompanyUserProfileController::class, 'getUserMenuAccess'])->name('user-profiles.menu-access');

        // Basic CRUD routes (less specific routes later)
        Route::get('user-profiles',                                [CompanyUserProfileController::class, 'index'])->name('user-profiles.index');
        Route::post('user-profiles',                               [CompanyUserProfileController::class, 'store'])->name('user-profiles.store');
        Route::get('user-profiles/{profile}/edit',                 [CompanyUserProfileController::class, 'edit'])->name('user-profiles.edit');
        Route::put('user-profiles/{profile}',                      [CompanyUserProfileController::class, 'update'])->name('user-profiles.update');
        Route::delete('user-profiles/{profile}',                   [CompanyUserProfileController::class, 'destroy'])->name('user-profiles.destroy');

        // Menu access routes for profiles
        Route::get('user-profiles/{profile}/menu-access',          [CompanyUserProfileController::class, 'getMenuAccess'])->name('user-profiles.get-menu-access');
        Route::post('user-profiles/{profile}/menu-access',         [CompanyUserProfileController::class, 'updateMenuAccess'])->name('user-profiles.update-menu-access');

        // Opportunity Routes
        Route::prefix('opportunities')->name('opportunities.')->group(function () {
            Route::get('/', [App\Http\Controllers\CRM\OpportunityController::class, 'index'])->name('index');
            Route::post('/', [App\Http\Controllers\CRM\OpportunityController::class, 'store'])->name('store');
            Route::put('/{id}', [App\Http\Controllers\CRM\OpportunityController::class, 'update'])->name('update');
            Route::delete('/{id}', [App\Http\Controllers\CRM\OpportunityController::class, 'destroy'])->name('destroy');
            Route::post('/export', [App\Http\Controllers\CRM\OpportunityController::class, 'export'])->name('export');
        });
    });

    // Partner Management Routes
    Route::prefix('company')->name('company.')->group(function () {
        Route::prefix('partners')->name('partners.')->group(function () {
            Route::get('/',                                       [CompanyPartnersController::class, 'index'])->name('index');
            Route::get('/create',                                 [CompanyPartnersController::class, 'create'])->name('create');
            Route::post('/',                                      [CompanyPartnersController::class, 'store'])->name('store');
            // --- Bulk Upload
            Route::get('/download-template',                      [CompanyPartnersController::class, 'downloadTemplate'])->name('partner-download-template');
            Route::post('/bulk-upload',                           [CompanyPartnersController::class, 'bulkUpload'])->name('partner-bulk-upload');

            Route::get('/{id}',                                   [CompanyPartnersController::class, 'show'])->name('show');
            Route::get('/{id}/edit',                              [CompanyPartnersController::class, 'edit'])->name('edit');
            Route::put('/{id}',                                   [CompanyPartnersController::class, 'update'])->name('update');
            Route::put('/{id}/status',                            [CompanyPartnersController::class, 'updateStatus'])->name('update-status');
            Route::delete('/{id}',                                [CompanyPartnersController::class, 'destroy'])->name('destroy');
        });
    });


    // User Categories Management Routes
    Route::prefix('company')->name('company-categories.')->group(function () {
        Route::get('/categories',                                [CompanyUserCategoriesController::class, 'index'])->name('index');
        Route::post('/categories',                               [CompanyUserCategoriesController::class, 'store'])->name('store');
        Route::put('/categories/{category}',                     [CompanyUserCategoriesController::class, 'update'])->name('update');
        Route::delete('/categories/{category}',                  [CompanyUserCategoriesController::class, 'destroy'])->name('destroy');
        Route::post('/categories/bulk-upload',                   [CompanyUserCategoriesController::class, 'bulkUpload'])->name('bulk-upload');
        Route::get('/categories/download-template',              [CompanyUserCategoriesController::class, 'downloadTemplate'])->name('download-template');
        Route::put('/categories/{category}/toggle-status',       [CompanyUserCategoriesController::class, 'toggleStatus'])->name('toggle-status');
    });

    // Customer Management Routes
    Route::prefix('company')->name('company.')->group(function () {
        Route::prefix('customers')->name('customers.')->group(function () {
            Route::get('/',                                      [CustomerManagment::class, 'index'])->name('index');
            Route::post('/all',                                      [CustomerManagment::class, 'showall'])->name('showall');
            Route::post('/',                                     [CustomerManagment::class, 'store'])->name('store');
            Route::post('/individual',                           [CustomerManagment::class, 'storeIndividual'])->name('store.individual');
            Route::get('/{id}/edit',                             [CustomerManagment::class, 'edit'])->name('edit');
            Route::get('/{id}/edit-individual',                  [CustomerManagment::class, 'edit'])->name('edit.individual');
            Route::put('/{id}',                                  [CustomerManagment::class, 'update'])->name('update');
            Route::delete('/{id}',                               [CustomerManagment::class, 'destroy'])->name('destroy');
            Route::get('/download-template',                     [CustomerManagment::class, 'downloadTemplate'])->name('download-template');
            Route::post('/bulk-upload',                          [CustomerManagment::class, 'bulkUpload'])->name('bulk-upload');
            Route::get('/{customer}/restore',                    [CustomerManagment::class, 'restore'])->name('restore');
            Route::get('/data',                                  [CustomerManagment::class, 'getData'])->name('data');
            Route::get('/search',                                [CustomerManagment::class, 'search'])->name('search');
            Route::get('/{customer}',                            [CustomerManagment::class, 'show'])->name('show');
        });
    });
    // CRM Leads Management Routes
    Route::prefix('company')->name('company.')->group(function () {
        Route::prefix('leads')->name('leads.')->group(function () {
            Route::post('/all',                              [App\Http\Controllers\CRM\CrmLeadsController::class, 'index'])->name('index');
            Route::post('/',                             [App\Http\Controllers\CRM\CrmLeadsController::class, 'store'])->name('store');
            Route::put('/{id}',                          [App\Http\Controllers\CRM\CrmLeadsController::class, 'update'])->name('update');
            Route::get('/{id}/edit',                     [App\Http\Controllers\CRM\CrmLeadsController::class, 'edit'])->name('edit');
            Route::delete('/{id}',                       [App\Http\Controllers\CRM\CrmLeadsController::class, 'destroy'])->name('destroy');

            Route::post('/bulk-upload',                  [App\Http\Controllers\CRM\CrmLeadsController::class, 'bulkUpload'])->name('bulk-upload');
            Route::get('/download-template',             [App\Http\Controllers\CRM\CrmLeadsController::class, 'downloadTemplate'])->name('download-template');
            // Additional Lead Actions
            Route::post('/schedule-appointment',         [App\Http\Controllers\CRM\CrmLeadsController::class, 'scheduleAppointment'])->name('schedule-appointment');
            Route::post('/convert-to-customer',          [App\Http\Controllers\CRM\CrmLeadsController::class, 'convertToCustomer'])->name('convert-to-customer');
        });
    });

    // CRM Dashboard Route
    Route::prefix('company')->name('company.')->group(function () {
        Route::get('CRM/crm', [App\Http\Controllers\CRM\CrmDashboardController::class, 'index'])->name('crm.dashboard');
    });

    // CRM Opportunity Routes
    Route::prefix('company')->name('company.')->group(function () {
        Route::prefix('opportunities')->name('opportunities.')->group(function () {
            Route::post('/all',                                       [App\Http\Controllers\CRM\OpportunityController::class, 'index'])->name('index');
            Route::get('/create',                                 [App\Http\Controllers\CRM\OpportunityController::class, 'create'])->name('create');
            Route::post('/',                                      [App\Http\Controllers\CRM\OpportunityController::class, 'store'])->name('store');
            Route::get('/{id}',                                   [App\Http\Controllers\CRM\OpportunityController::class, 'show'])->name('show');
            Route::get('/{id}/edit',                              [App\Http\Controllers\CRM\OpportunityController::class, 'edit'])->name('edit');
            Route::put('/{id}',                                   [App\Http\Controllers\CRM\OpportunityController::class, 'update'])->name('update');
            Route::delete('/{id}',                                [App\Http\Controllers\CRM\OpportunityController::class, 'destroy'])->name('destroy');
            Route::put('/{id}/status',                            [App\Http\Controllers\CRM\OpportunityController::class, 'updateStatus'])->name('status');
            Route::post('/export',                                [App\Http\Controllers\CRM\OpportunityController::class, 'export'])->name('export');
        });
    });

    // Campaign routes
    Route::prefix('company')->name('company.')->group(function () {
        Route::prefix('campaigns')->name('campaigns.')->group(function () {
            Route::post('/all', [CampaignController::class, 'index'])->name('index'); // List campaigns
            Route::get('/create', [CampaignController::class, 'create'])->name('create'); // Show form
            Route::post('/store', [CampaignController::class, 'store'])->name('store'); // Handle form submission
            Route::get('/{id}/edit', [CampaignController::class, 'edit'])->name('edit'); // Edit form
            Route::put('/campaigns/{campaign}', [CampaignController::class, 'update'])->name('update');
            Route::delete('/{campaign}', [CampaignController::class, 'destroy'])->name('destroy');
            Route::get('/filter', [CampaignController::class, 'filter'])->name('filter');

        });
    });

    // Email Management Routes
    Route::prefix('company')->middleware(['auth', 'company.session'])->group(function () {
        Route::prefix('email')->group(function () {
            Route::get('/sent',                      [EmailManagement::class, 'getSentEmails'])->name('company.email.sent');
            Route::get('/deleted',                   [EmailManagement::class, 'getDeletedEmails'])->name('company.email.deleted');
            Route::get('/drafts',                    [EmailManagement::class, 'getDraftEmails'])->name('company.email.drafts');
            Route::get('/drafts/{id}',               [EmailManagement::class, 'getDraft'])->name('company.email.draft.get');
            Route::delete('/drafts/{id}',            [EmailManagement::class, 'deleteDraft'])->name('company.email.draft.delete');
            Route::post('/save-draft',               [EmailManagement::class, 'saveDraft'])->name('company.email.draft.save');
            Route::post('/send',                     [EmailManagement::class, 'sendEmail'])->name('company.email.send');
            Route::post('/delete',                   [EmailManagement::class, 'deleteEmail'])->name('company.email.delete');
            Route::post('/restore',                  [EmailManagement::class, 'restoreEmail'])->name('company.email.restore');
        });
    });

    // CRM Activity Routes
    Route::prefix('company')->name('company.')->group(function () {
        Route::prefix('crm')->name('crm.')->group(function () {
            Route::post('/activities/all', [ActivityController::class, 'index'])->name('activities.index');
            Route::get('/activities/create', [ActivityController::class, 'create'])->name('activities.create');
            Route::post('/activities', [ActivityController::class, 'store'])->name('activities.store');
            Route::get('/activities/{activity}', [ActivityController::class, 'show'])->name('activities.show');
            Route::put('/activities/{activity}', [ActivityController::class, 'update'])->name('activities.update');
            Route::delete('/activities/{activity}', [ActivityController::class, 'destroy'])->name('activities.destroy');
            Route::get('/activities/refresh', [ActivityController::class, 'refresh'])->name('activities.refresh');
            Route::post('/activities/{activity}/complete', [ActivityController::class, 'complete'])->name('activities.complete');
          
            
            Route::POST('/activities/statistics', [ActivityController::class, 'getActivityStatistics'])->name('activities.statistics');
        });
    });

    // CRM Contract Management Routes
    Route::prefix('company')->name('company.')->group(function () {
        Route::prefix('CRM/contract')->name('contract.')->group(function () {
            Route::get('/', [ContractController::class, 'index'])->name('index');
            Route::post('/', [ContractController::class, 'store'])->name('store');
            Route::get('/{id}/show', [ContractController::class, 'show'])      ->name('show');
            Route::match(['put', 'post'], '/edit/{id}', [ContractController::class, 'update'])->name('update');
            Route::delete('/delete/{id}', [ContractController::class, 'destroy'])->name('destroy');
            Route::get('/{id}/download', [ContractController::class, 'download']) ->name('download');
            Route::post('/send-for-signature/{id}', [ContractController::class, 'sendForSignature'])->name('send-for-signature');
            Route::get('/filter', [ContractController::class, 'filter'])->name('filter');
            Route::post('/{id}/comment', [ContractController::class, 'addComment'])->name('comment.add');
            Route::post('/{id}/reminder', [ContractController::class, 'addReminder'])->name('reminder.add');
            Route::get('/{id}/audit-trail', [ContractController::class, 'getAuditTrail'])->name('audit-trail');
        });
    });

    // CRM Activity Routes
    Route::prefix('crm')->middleware(['auth', 'company.session'])->group(function () {
        Route::get('/activities', [ActivityController::class, 'index'])->name('crm.activities.index');
        Route::post('/activities', [ActivityController::class, 'store'])->name('crm.activities.store');
        Route::put('/activities/{id}', [ActivityController::class, 'update'])->name('crm.activities.update');
        Route::delete('/activities/{id}', [ActivityController::class, 'destroy'])->name('crm.activities.destroy');
        Route::post('/activities/{id}/complete', [ActivityController::class, 'complete'])->name('crm.activities.complete');
        Route::post('/activities/create', [ActivityController::class, 'store'])->name('company.crm.activities.create');
     
    });

    // Newsletter Management Routes
    Route::prefix('company/newsletters')->name('company-newsletters.')->group(function () {
        Route::get('/',                              [CompanyNewsLetterController::class, 'index'])->name('index');
        Route::post('/',                             [CompanyNewsLetterController::class, 'store'])->name('store');
        Route::get('/{companyNewsLetter}/edit',      [CompanyNewsLetterController::class, 'edit'])->name('edit');
        Route::put('/{companyNewsLetter}',           [CompanyNewsLetterController::class, 'update'])->name('update');
        Route::delete('/{companyNewsLetter}',        [CompanyNewsLetterController::class, 'destroy'])->name('destroy');
    });

    // -- Routes for individual & company dashboards views
    Route::get('/company/index',           [CompanyUserController::class,         'index'])->name('dash.company');
    Route::get('/individual/index',        [IndividualUserController::class,      'index'])->name('dash.individual');

    Route::get('{first}/{second}/{third}', [RoutingController::class,  'thirdLevel'])->name('third');
    Route::get('{first}/{second}',         [RoutingController::class,  'secondLevel'])->name('second');
    Route::get('{any}',                    [RoutingController::class,  'root'])->name('any');

    // CRM Sales Routes
    Route::prefix('company')->name('company.')->group(function () {
        Route::prefix('sales')->name('sales.')->group(function () {
            Route::post('/salescategories', [App\Http\Controllers\CRM\CrmSalesController::class, 'saleCategory'])->name('saleCategory');
            Route::POST('/statistics', [App\Http\Controllers\CRM\CrmSalesController::class, 'getDashboardStats'])->name('statistics');
            Route::post('/all',            [App\Http\Controllers\CRM\CrmSalesController::class, 'index'])        ->name('index');
            Route::post('/dealexport',     [App\Http\Controllers\CRM\CrmSalesController::class, 'export'])       ->name('dealexport');
            Route::post('/sale_categories', [App\Http\Controllers\CRM\CrmSalesController::class, 'getSalesCategory'])->name('getSalesCategory');
            Route::get('/create',      [App\Http\Controllers\CRM\CrmSalesController::class, 'create'])       ->name('create');
            Route::post('/',           [App\Http\Controllers\CRM\CrmSalesController::class, 'store'])        ->name('store');
            Route::post('/{id}',        [App\Http\Controllers\CRM\CrmSalesController::class, 'show'])         ->name('show');
            Route::get('/{id}/edit',   [App\Http\Controllers\CRM\CrmSalesController::class, 'edit'])         ->name('edit');
            Route::put('/{id}',        [App\Http\Controllers\CRM\CrmSalesController::class, 'update'])       ->name('update');
            Route::delete('/{id}',     [App\Http\Controllers\CRM\CrmSalesController::class, 'destroy'])      ->name('destroy');
            Route::put('/{id}/status', [App\Http\Controllers\CRM\CrmSalesController::class, 'updateStatus'])->name('status');
        });
    });

    Route::prefix('company')->name('company.')->group(function () {
        Route::prefix('support')->name('support.')->group(function () {
            Route::post('/show', [App\Http\Controllers\CRM\TicketController::class, 'show'])->name('show');
            Route::post('/all', [App\Http\Controllers\CRM\TicketController::class, 'index'])->name('index'); // List all tickets
            Route::post('/', [App\Http\Controllers\CRM\TicketController::class, 'store'])->name('store'); // Create a ticket
            Route::delete('/{ticket}', [App\Http\Controllers\CRM\TicketController::class, 'destroy'])->name('destroy'); // Soft delete ticket
        });
    });
});
