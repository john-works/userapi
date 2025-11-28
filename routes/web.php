<?php

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

use App\Http\Controllers\RouteClosureController;
use App\Http\Controllers\UserController;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\View;

Route::group(['middleware' => ['web']], function (){

    /*
     * This is used to handle referral URLs
     * */
    Route::get('/auth/ref/{toApp}/{params?}', 'UserController@referralLogin')->where('params', '(.*)');

    Route::get('/', [RouteClosureController::class, 'login']);

    /*
     * This loads the login page
     * */
    Route::get('login/{redirectToApp?}/{redirectSpecificPage?}',[UserController::class, 'index'])->name('login');


    /*
     * This is for processing the user login
     * */
    Route::post('/users/signin',
        [
            'uses' => 'UserController@signin',
            'as' => 'signin'
        ]);
    Route::get('/user/logout',
        [
            'uses' => 'UserController@logoutUser',
            'as' => 'logout_user'
        ]);
    Route::get('/user/back-to-ppda-apps',
        [
            'uses' => 'Auth\LoginController@redirectBackToPpdaApps',
            'as' => 'back-to-ppda-apps'
    ]);
    Route::get('/password/forgot',
        [
            'uses' => 'UserController@getResetPasswordForm',
            'as' => 'user.forgot-password'
        ]);

    Route::post('/password/reset',
        [
            'uses' => 'UserController@resetPassword',
            'as' => 'user.reset-password'
        ]);

    Route::get('/admin/signout/{redirectToApp?}/{redirectSpecificPage?}',
        [
            'uses' => 'UserController@signoutAdmin',
            'as' => 'singout_admin'
        ]);

    Route::get('/password/change-auto-form',
        [
            'uses' => 'UserController@getChangeDefaultPasswordForm',
            'as' => 'user.password.change-auto.form'
        ]);

    Route::post('/password/change-auto-password',
        [
            'uses' => 'UserController@changeDefaultPassword',
            'as' => 'user.password.change-default'
        ]);
        
    Route::prefix('tickets')->group(function (){
        Route::get('/index/{username}', 'TicketController@index')->name('tickets.index');
        Route::get('/create/{username}', 'TicketController@create')->name('tickets.create');
        Route::post('/reopen', 'TicketController@reopen')->name('tickets.reopen');
        Route::post('/store', 'TicketController@store')->name('tickets.store');
        Route::post('/save_reopen', 'TicketController@saveReopen')->name('ticket_reopens.store');

    });

    Route::prefix('driver_requests')->group(function (){
        Route::get('/index/{username}', 'DriverRequestController@index')->name('driver_requests.index');
        Route::get('/create/{username}', 'DriverRequestController@create')->name('driver_requests.create');
        Route::post('/store', 'DriverRequestController@store')->name('driver_requests.store');
    });

    Route::get('/create_fuel_issue/{username}', 'DriverRequestController@createFuelIssue')->name('fuel_issues.create');       
    Route::get('/public_holidays', 'HolidayController@index')->name('public_holidays.index');    
    Route::post('/holidays_range', 'HolidayController@getRange')->name('public_holidays.get_range');    
    Route::post('/holidays_year', 'HolidayController@getYear')->name('public_holidays.get_year');        
    Route::post('/store_fuel_issue', 'DriverRequestController@storeFuelIssue')->name('fuel_issues.store');    
    Route::get('/timo/testscripts', 'RouteClosureController@test');    
    Route::get('important-contacts', 'RouteClosureController@important_contacts')->name('important-contacts');
    Route::get('trusted-device/currentstatus','TrustedDevicesController@trustedDeviceCurrentStatus')->name('trusted-devices.currentstatus');
    Route::get('trusted-device/ajax','TrustedDevicesController@getTrustedDeviceInfoAjax')->name('trusted-devices.ajax');
    Route::get('starter_data','TrustedDevicesController@straterData')->name('starter_data.ajax');
    Route::get('trusted-device/current/list/{deviceId?}','TrustedDevicesController@trustedDeviceCurrentList')->name('trusted-devices.current.list');
    Route::get('trusted-device/current/revoke/{deviceDetails}','TrustedDevicesController@trustedDevicesRevokeCurrent')->name('trusted_devices.current.revoke');
    Route::get('trusted-device/current/action_history/{deviceId}','TrustedDevicesController@trustedDeviceCurrentActionHistory')->name('trusted_devices.current.action-history');
    Route::get('trusted-device/current/action_history_list/{deviceId}','TrustedDevicesController@trustedDeviceCurrentActionHistoryList')->name('trusted-devices.current.action-history.list');
    Route::get('/trusted-users/{username?}','ActionlogController@trustedUserTasks')->name('trusted-users.tasks');
    Route::get('/trusted_user/{username}','ActionlogController@trustedUserActionLogList')->name('trusted_user_action_logs.list');
    Route::get('events/department','EventController@departmentCalendar')->name('events.department');
    Route::get('/employee_360_view','EmployeeViewController@index')->name('employee_360_view.index');
    Route::get('app/usage/report','ApplicationUsageTrackerController@report')->name('app.usage.report');
    Route::post('app/usage/report','ApplicationUsageTrackerController@generate')->name('generate.app.usage.report');

    Route::prefix('pending-actions')->group(function(){
        Route::get('my','PendingActionController@my_pending_actions')->name('my.pending.actions');
    });
    // leave_requests.more
    Route::get('more_leave_requests/{username}','LeaveRequestController@moreLeave')->name('leave_requests.more');
    Route::get('more_appraisal_requests/{username}','LeaveRequestController@moreAppraisal')->name('appraisal_requests.more');
});



/*
 * Routes below are only accessible by authorized users see, AuthorizedUserAccess middleware for logic
 * */

Route::group(['middleware' => ['web', 'users.authorized' /*'auth'*/]], function (){
    Route::get('session-history/index','SessionHistoryController@index')->name('session-history');
    Route::get('session-history/for-user/list','SessionHistoryController@sessionHistoryForUserList')->name('session-history.for-user.list');

    Route::get('out-of-office/index','OutOfOfficeController@outOfOfficeIndex')->name('out-of-office');
    Route::get('out-of-office/list','OutOfOfficeController@outOfOfficeListAssignedByMe')->name('out-of-office.list');
    Route::get('out-of-office/list/assigned-to-me','OutOfOfficeController@outOfOfficeListAssignedTo')->name('out-of-office.list.assigned-to-me');
    Route::get('out-of-office/create/{enableUserSelection?}','OutOfOfficeController@outOfOfficeCreate')->name('out-of-office.create');
    Route::post('out-of-office/store','OutOfOfficeController@outOfOfficeStore')->name('out-of-office.store');
    Route::get('out-of-office/delete/{outOfOffice}','OutOfOfficeController@outOfOfficeRemove')->name('out-of-office.remove');
    Route::get('out-of-office/admin','OutOfOfficeController@outOfOfficeAdminIndex')->name('out-of-office.admin');
    Route::get('out-of-office/admin/list','OutOfOfficeController@outOfOfficeAdminList')->name('out-of-office.admin.list');
    Route::get('out-of-office/admin/history','OutOfOfficeController@outOfOfficeAdminHistory')->name('out-of-office.admin.history');
    Route::get('out-of-office/admin/history/list','OutOfOfficeController@outOfOfficeAdminHistoryList')->name('out-of-office.admin.history.list');
    Route::get('out-of-office/owner/history','OutOfOfficeController@outOfOfficeOwnerHistoryIndex')->name('out-of-office.owner.history');
    Route::get('out-of-office/owner/history/list/{type}','OutOfOfficeController@outOfOfficeOwnerHistoryList')->name('out-of-office.owner.history.list');

    Route::get('trusted-device/set-confirmation/{browser}','TrustedDevicesController@trustedDevicesSetConfirmation')->name('trusted-devices.set-confirm');
    Route::get('trusted-device/send-confirmation-code/{deviceDetails}','TrustedDevicesController@trustedDevicesSendConfirmationCode')->name('trusted-devices.send-confirmation-code');
    Route::post('trusted-device/save','TrustedDevicesController@trustedDevicesSave')->name('trusted-devices.save');
    Route::get('trusted-device/status','TrustedDevicesController@trustedDeviceStatus')->name('trusted-devices.status');
    Route::get('trusted-device/admin','TrustedDevicesController@trustedDeviceAdminIndex')->name('trusted-devices.admin');
    Route::get('trusted-device/admin/list/{deviceId?}','TrustedDevicesController@trustedDeviceAdminList')->name('trusted-devices.admin.list');
    Route::get('trusted-device/admin/action-history/{deviceId}','TrustedDevicesController@trustedDeviceAdminActionHistory')->name('trusted-devices.admin.action-history');
    Route::get('trusted-device/admin/action-history-list/{deviceId}','TrustedDevicesController@trustedDeviceAdminActionHistoryList')->name('trusted-devices.admin.action-history.list');
    Route::get('trusted-device/admin/approve/{deviceId}','TrustedDevicesController@trustedDevicesApprove')->name('trusted-devices.admin.approve');
    Route::get('trusted-device/admin/revoke/{deviceId}/{revokeComment}','TrustedDevicesController@trustedDevicesRevokeAdmin')->name('trusted-devices.admin.revoke');
    Route::get('trusted-device/revoke/{deviceDetails}','TrustedDevicesController@trustedDevicesRevoke')->name('trusted-devices.revoke');
    Route::get('trusted-device/admin/revoke-user','TrustedDevicesController@trustedDeviceAdminRevokeUserForm')->name('trusted-devices.admin.revoke-user');
    Route::post('trusted-device/admin/revoke-user','TrustedDevicesController@trustedDeviceAdminRevokeUser')->name('trusted-devices.admin.revoke-user.save');

    Route::get('/error_logs', 'JobErrorLogsController@error_logs')->name('administration.error_logs');
    Route::get('/job_status_tracker_datatables', 'JobErrorLogsController@job_status_tracker_datatables')->name('job_status_tracker_datatables');
    Route::get('/error_log_details/{error_log}', 'JobErrorLogsController@error_log_details')->name('error_log_details');

    Route::get('/run_jobs', 'JobErrorLogsController@run_jobs')->name('administration.run_jobs');
    Route::get('/run_jobs/trigger/{command}', 'JobErrorLogsController@trigger_job')->name('administration.run_jobs.trigger');

    Route::get('/ppda-apps/selection',
        [
            'uses' => 'UserController@getAppSelectionView',
            'as' => 'users.app-selection'
        ]);

    Route::get('/users/access-app/{app}',
        [
            'uses' => 'UserController@accessApp',
            'as' => 'users.access-app'
        ]);


    Route::get('/admin/dashboard',
        [
            'uses' => 'UserController@getAdminDashboard',
            'as' => 'admin_dashboard'
        ]);

    Route::get('/users/dashboard',
        [
            'uses' => 'UserController@getUserDashboard',
            'as' => 'user_dashboard'
        ]);


    Route::get('/users/profile',
        [
            'uses' => 'UserController@getUserProfilePage',
            'as' => 'users.profile'
        ]);

    Route::get('/users/academic-bg/{id}',
        [
            'uses' => 'UserController@showAcademicBg',
            'as' => 'users.profile.academic-bg'
        ]);


    Route::post('/users/update-profile',
        [
            'uses' => 'UserController@updateUserProfileByOwner',
            'as' => 'users.update-own-profile'
        ]);

    Route::post('/users/academic-bg-save',
        [
            'uses' => 'UserController@saveUserAcademicBackgroundAjax',
            'as' => 'users.academic-bg-save'
        ]);

    Route::post('/users/academic-bg-update',
        [
            'uses' => 'UserController@updateUserAcademicBackgroundAjax',
            'as' => 'users.academic-bg-update'
        ]);

    Route::get('/users/academic-bg/delete/{id}',
        [
            'uses' => 'UserController@deleteAcademicBackground',
            'as' => 'users.academic-bg.delete'
        ]);

    /*
     * Begin routes for users
     * */
    Route::get('/users/new',
        [
            'uses' => 'UserController@getCreationUserForm',
            'as' => 'users.form'
        ]);

    Route::post('/users/store',
        [
            'uses' => 'UserController@saveUserAjax',
            'as' => 'users.store'
        ]);

    Route::get('/settings/users',
        [
            'uses' => 'UserController@allUsers',
            'as' => 'users.all'
        ]);

    Route::post('/users/edit',
        [
            'uses' => 'UserController@updateUser',
            'as' => 'users.update'
        ]);

    Route::get('/users/password',
        [
            'uses' => 'UserController@getPasswordChangeForm',
            'as' => 'users.change-password-form'
        ]);

    Route::post('/users/password/edit',
        [
            'uses' => 'UserController@changePassword',
            'as' => 'change_password'
        ]);


    Route::get('/users/delete/{id}',
        [
            'uses' => 'UserController@deleteProfile',
            'as' => 'delete_user_profile'
        ]);

    /*
     * Begin routes for organizations
     * */

    Route::get('/settings/organizations',
        [
            'uses' => 'SettingsController@allOrganizations',
            'as' => 'organization.all'
        ]);

    Route::get('/settings/organizations/new',
        [
            'uses' => 'SettingsController@getCreationOrganizationForm',
            'as' => 'organization.form'
        ]);

    Route::post('/settings/organizations/store',
        [
            'uses' => 'SettingsController@saveOrgAjax',
            'as' => 'organization.store'
        ]);

    Route::post('/settings/organizations/edit',
        [
            'uses' => 'SettingsController@editOrganization',
            'as' => 'organizations.update'
        ]);

    Route::get('/settings/organizations/delete/{id}',
        [
            'uses' => 'SettingsController@deleteOrganization',
            'as' => 'organizations.delete'
        ]);

    /*
 * Begin routes for regional offices
 * */

    Route::get('/settings/regional-offices',
        [
            'uses' => 'SettingsController@allRegionalOffices',
            'as' => 'regional-offices.all'
        ]);

    Route::get('/settings/regional-offices/new',
        [
            'uses' => 'SettingsController@getCreationRegionalOfficeForm',
            'as' => 'regional-offices.form'
        ]);

    Route::post('/settings/regional-offices/store',
        [
            'uses' => 'SettingsController@saveRegionalOfficeAjax',
            'as' => 'regional-offices.store'
        ]);

    Route::post('/settings/regional-offices/edit',
        [
            'uses' => 'SettingsController@editRegionalOffice',
            'as' => 'regional-offices.update'
        ]);

    Route::get('/settings/regional-offices/delete/{id}',
        [
            'uses' => 'SettingsController@deleteRegionalOffice',
            'as' => 'regional-offices.delete'
        ]);


    /*
     * End routes for regional offices
     * */



    /*
     * Begin routes for departments
     * */
    Route::get('/settings/departments',
        [
            'uses' => 'SettingsController@allDepartments',
            'as' => 'departments.all'
        ]);

    Route::get('/settings/departments/new',
        [
            'uses' => 'SettingsController@getCreationDepartmentForm',
            'as' => 'departments.form'
        ]);

    Route::post('/settings/departments/store',
        [
            'uses' => 'SettingsController@saveDepartmentAjax',
            'as' => 'departments.store'
        ]);

    Route::post('/settings/departments/edit',
        [
            'uses' => 'SettingsController@editDepartment',
            'as' => 'departments.update'
        ]);

    Route::get('/settings/departments/delete/{id}',
        [
            'uses' => 'SettingsController@deleteDepartment',
            'as' => 'departments.delete'
        ]);

    /*
     * End routes for departments
     * */


    /*
     * Begin routes for designations
     * */
    Route::get('/settings/designations','SettingsController@allDesignations')->name('designations.all');
    Route::get('/settings/designations/new','SettingsController@getCreationDepartmentForm')->name('designations.form');
    Route::post('/settings/designations/store','SettingsController@saveDesignation')->name('designations.store');
    Route::post('/settings/designations/edit','SettingsController@updateDesignation')->name('designations.update');
    Route::get('/settings/designations/delete/{id}','SettingsController@deleteDesignation')->name('designations.delete');
    /*
     * End routes for departments
     * */



    /*
     * Begin Strategic Objectives
     * */
    Route::get('/settings/strategic-objectives',
        [
            'uses' => 'SettingsController@allStrategicObjectives',
            'as' => 'admin.objectives.all'
        ]);
    Route::post('/settings/strategic-objectives-save',
        [
            'uses' => 'SettingsController@saveStrategicObjectiveAjax',
            'as' => 'admin.strategic-objectives.save'
        ]);

    Route::post('/settings/strategic-objectives-update',
        [
            'uses' => 'SettingsController@updateStrategicObjectiveAjax',
            'as' => 'admin.strategic-objectives.update'
        ]);
    Route::get('/settings/strategic-objectives/delete/{id}',
        [
            'uses' => 'SettingsController@deleteStrategicObjective',
            'as' => 'admin.strategic-objectives.delete'
        ]);
    /*
     * End Strategic Objectives
     * */


    /*
     * Begin Admin Compentece Categories
     * */
    Route::get('/settings/competence-categories',
        [
            'uses' => 'SettingsController@allCompetenceCategories',
            'as' => 'admin.competence-categories.all'
        ]);

    Route::post('/settings/competence-categories-save',
        [
            'uses' => 'SettingsController@saveCompetenceCategoryAjax',
            'as' => 'admin.competence-categories.save'
        ]);

    Route::post('/settings/competence-categories-update',
        [
            'uses' => 'SettingsController@updateCompetenceCategoryAjax',
            'as' => 'admin.competence-categories.update'
        ]);

    Route::get('/settings/competence-categories/{id}/competences',
        [
            'uses' => 'SettingsController@getCompetenceCategoryCompetences',
            'as' => 'admin.competence-categories.show-competences'
        ]);

    Route::get('/settings/competence-categories/delete/{id}',
        [
            'uses' => 'SettingsController@deleteCompetenceCategory',
            'as' => 'admin.competence-categories.delete'
        ]);


    /*
     * Begin competence
     * */
    Route::post('/settings/competences-save',
        [
            'uses' => 'SettingsController@saveCompetenceAjax',
            'as' => 'admin.competences.save'
        ]);

    Route::post('/settings/competences-update',
        [
            'uses' => 'SettingsController@updateCompetenceAjax',
            'as' => 'admin.competences.update'
        ]);

    Route::get('/settings/competences/delete/{categoryId}/{id}',
        [
            'uses' => 'SettingsController@deleteCompetence',
            'as' => 'admin.competences.delete'
        ]);

    Route::get('/settings/appraisals/incomplete/{statusFilter?}',
        [
            'uses' => 'SettingsController@getAdminIncompleteAppraisals',
            'as' => 'admin.appraisals.incomplete'
        ]);

    Route::get('/settings/appraisals/complete',
        [
            'uses' => 'SettingsController@getAdminCompletedAppraisals',
            'as' => 'admin.appraisals.complete'
        ]);

    Route::post('/settings/appraisals/update-approvers',
        [
            'uses' => 'SettingsController@updateAppraisalApproversAjax',
            'as' => 'admin.appraisals.update-approvers'
        ]);

    /*
     * Edn Admin Competence Cateogries
     * */


    /*
    * Begin routes for employee categories
    * */

    Route::get('/settings/employee-categories',
        [
            'uses' => 'SettingsController@allEmployeeCategories',
            'as' => 'employee-categories.all'
        ]);

    Route::get('/settings/employee-categories/new',
        [
            'uses' => 'SettingsController@getCreationEmployeeCategoryForm',
            'as' => 'employee-categories.form'
        ]);

    Route::post('/settings/employee-categories/store',
        [
            'uses' => 'SettingsController@saveEmployeeCategoryAjax',
            'as' => 'employee-categories.store'
        ]);

    Route::post('/settings/employee-categories/edit',
        [
            'uses' => 'SettingsController@editEmployeeCategory',
            'as' => 'employee-categories.update'
        ]);

    Route::get('/settings/employee-categories/delete/{id}',
        [
            'uses' => 'SettingsController@deleteEmployeeCategory',
            'as' => 'employee-categories.delete'
        ]);

    /*
     * End routes for  employee categories
     * */



    /*
     * Begin Admin Compentece Categories
     * */
    Route::get('/settings/behavioral-competence-categories',
        [
            'uses' => 'BehavioralCompetenceCategoryController@all',
            'as' => 'admin.behavioral-competence-categories.all'
        ]);

    Route::post('/settings/behavioral-competence-categories-save',
        [
            'uses' => 'BehavioralCompetenceCategoryController@save',
            'as' => 'admin.behavioral-competence-categories.save'
        ]);

    Route::post('/settings/behavioral-competence-categories-update',
        [
            'uses' => 'BehavioralCompetenceCategoryController@update',
            'as' => 'admin.behavioral-competence-categories.update'
        ]);

    Route::get('/settings/behavioral-competence-categories/{id}/competences',
        [
            'uses' => 'BehavioralCompetenceCategoryController@getCompetenceCategoryCompetences',
            'as' => 'admin.behavioral-competence-categories.show-competences'
        ]);

    Route::get('/settings/behavioral-competence-categories/delete/{id}',
        [
            'uses' => 'BehavioralCompetenceCategoryController@delete',
            'as' => 'admin.behavioral-competence-categories.delete'
        ]);


    /*
 * Begin competence
 * */
    Route::post('/settings/behavioral-competences-save',
        [
            'uses' => 'BehavioralCompetenceCategoryController@saveCompetence',
            'as' => 'admin.behavioral-competences.save'
        ]);

    Route::post('/settings/behavioral-competences-update',
        [
            'uses' => 'BehavioralCompetenceCategoryController@updateCompetence',
            'as' => 'admin.behavioral-competences.update'
        ]);

    Route::get('/settings/behavioral-competences/delete/{categoryId}/{id}',
        [
            'uses' => 'BehavioralCompetenceCategoryController@deleteCompetence',
            'as' => 'admin.behavioral-competences.delete'
        ]);





    /*
 * Begin routes for units
 * */
    Route::get('/settings/department-units',
        [
            'uses' => 'SettingsController@allDepartmentUnits',
            'as' => 'department-units.all'
        ]);

    Route::post('/settings/department-units/store',
        [
            'uses' => 'SettingsController@saveDepartmentUnitAjax',
            'as' => 'department-units.store'
        ]);

    Route::post('/settings/department-units/edit',
        [
            'uses' => 'SettingsController@updateDepartmentUnitViaApi',
            'as' => 'department-units.update'
        ]);

    Route::get('/settings/department-units/delete/{id}',
        [
            'uses' => 'SettingsController@deleteDepartmentUnit',
            'as' => 'department-units.delete'
        ]);

    /*
     * End routes for units
     * */
    Route::prefix('actionlogs')->group(function (){
        Route::get('/{menu_selected?}','ActionlogController@index')->name('actionlogs');
        Route::get('/department_index/{status?}', 'ActionlogController@departmentIndex')->name('actionlogs.department');
        Route::get('/department_list/{status?}','ActionlogController@departmentList')->name('department_actionlogs.list');
        Route::get('/list/{menu_selected}','ActionlogController@list')->name('actionlogs.list');
        Route::get('/edit/{actionlog}','ActionlogController@edit')->name('actionlogs.edit');
        Route::get('/to_pending/{actionlog}','ActionlogController@toPending')->name('actionlogs.to_pending');
        Route::post('/pend_closure','ActionlogController@pendClosure')->name('actionlogs.pend_close');
        Route::get('/complete/{actionlog}','ActionlogController@complete')->name('actionlogs.complete');
        Route::post('/close','ActionlogController@close')->name('actionlogs.close');
        Route::get('/create/{menu}','ActionlogController@create')->name('actionlogs.create');
        Route::post('/store','ActionlogController@store')->name('actionlogs.store');
        Route::post('/storeupdates','ActionlogController@storeUpdates')->name('statusupdates.store');
        Route::post('/storetasks','ActionlogController@storeTask')->name('actionlog_tasks.store');
        Route::get('/createupdates/{actionlog}','ActionlogController@createUpdates')->name('statusupdates.create');
        Route::get('/createtask/{actionlog}','ActionlogController@createTask')->name('statusupdates.create_task');
        Route::get('/getupdates/{actionlog}','ActionlogController@getUpdates')->name('statusupdates.get');
        Route::delete('/delete/{actionlog}','ActionlogController@delete')->name('actionlogs.delete');
        Route::get('/upadate-details/list/{request}','ActionlogController@updateDetailsList')->name('status_update_details.list');
        Route::get('/tasks/{request}','ActionlogController@taskList')->name('action_log_tasks.list');
        Route::get('/tasks_notes/{action_log_task}','ActionlogController@addCompletionNote')->name('action_log_tasks.complete');
        Route::post('/complete_task','ActionlogController@completeTask')->name('action_log_tasks.close');
        Route::post('/reopen_task','ActionlogController@reopenTask')->name('action_log_tasks.reopen');

    });

    Route::prefix('calendar')->group(function (){
        Route::get('/listCalendars','CalendarController@listCalendars')->name('calendars');
        Route::get('/users','CalendarController@listUsers')->name('calendar_users.index');
        Route::get('/create','CalendarController@create')->name('calendars.create');
        Route::post('/store','CalendarController@store')->name('calendars.store');
        Route::get('/add_users','CalendarController@createUsers')->name('calendar_users.create');
        Route::post('/store_users','CalendarController@storeUsers')->name('calendar_users.store');
        Route::get('/list','CalendarController@list')->name('calendar_users.list');
        Route::get('/types/list','CalendarController@calendarTypesList')->name('calendar_types.list');
        Route::get('/type_admins/{calendar_type}','CalendarController@AdminList')->name('calendar_type_admins.list');
        Route::get('/type_admins/{calendar_type_admin}','CalendarController@calendarTypesAdminsRemove')->name('calendar_type_admins.remove');
        Route::get('/types/{calendar_type}','CalendarController@calendarTypesshow')->name('calendar_types.show');
        Route::get('/calendar_types/{calendar_type}','CalendarController@calendarTypeAdminCreate')->name('calendar_type_admins.create');
        Route::post('/calendar_types','CalendarController@calendarTypeAdminStore')->name('calendar_type_admins.store');
        Route::get('/colors/{calendar}','CalendarController@calendarColorEdit')->name('calendar_colors.edit');
        Route::get('/delete/{calendar_user}','CalendarController@destroy')->name('calendar_users.delete');
    });

    Route::prefix('events')->group(function (){
        Route::get('events/{calendar_type?}','EventController@index')->name('events');
        Route::get('/{event?}','EventController@edit')->name('getevent');
        Route::post('/store','EventController@store')->name('events.store');
        Route::put('/update/{event}','EventController@update')->name('events.update');
        Route::delete('/delete/{event}','EventController@destroy')->name('events.delete');
    });
    Route::get('/session_entities','EventController@sessionEntities')->name('session.entities');
    Route::prefix('board_committees')->group(function(){
        Route::get('/create','BoardCommitteeController@create')->name('board_committees.create');
        Route::post('/store','BoardCommitteeController@store')->name('board_committees.store');
        Route::get('/list','BoardCommitteeController@list')->name('board_committees.list');
        Route::get('/edit/{board_committee}','BoardCommitteeController@edit')->name('board_committees.edit');
        Route::get('/delete/{board_committee}', 'BoardCommitteeController@destroy')->name('board_committees.delete');
    });
    Route::prefix('audit_types')->group(function(){
        Route::get('/create','AuditTypeController@create')->name('audit_types.create');
        Route::post('/store','AuditTypeController@store')->name('audit_types.store');
        Route::get('/list','AuditTypeController@list')->name('audit_types.list');
        Route::get('/edit/{auditType}','AuditTypeController@edit')->name('audit_types.edit');
        Route::get('/delete/{auditType}', 'AuditTypeController@destroy')->name('audit_types.delete');
    });
    Route::prefix('audit_activities')->group(function(){
        Route::get('/','AuditActivityController@allActivities')->name('audit_activities.all');
        Route::get('/create','AuditActivityController@create')->name('audit_activities.create');
        Route::post('/store','AuditActivityController@store')->name('audit_activities.store');
        Route::get('/list','AuditActivityController@list')->name('audit_activities.list');
        Route::get('/edit/{auditActivity}','AuditActivityController@edit')->name('audit_activities.edit');
        Route::get('/delete/{auditActivity}', 'AuditActivityController@destroy')->name('audit_activities.delete');
    });
    Route::prefix('action_log_admins')->group(function(){
        Route::get('/','ActionLogAdminController@index')->name('action_log_admins');
        Route::get('/department/{department}','ActionLogAdminController@show')->name('action_log_admins.show');
        Route::get('/create/{department}','ActionLogAdminController@create')->name('action_log_admins.create');
        Route::post('/store','ActionLogAdminController@store')->name('action_log_admins.store');
        Route::get('/list','ActionLogAdminController@list')->name('action_log_admins.list');
        Route::get('/department/list/{department}','ActionLogAdminController@departmentList')->name('department_logger_amins.list');
        Route::get('/edit/{action_log_admin}','ActionLogAdminController@edit')->name('action_log_admins.edit');
        Route::get('/admins_delete/{action_log_admin}', 'ActionLogAdminController@destroy')->name('action_log_admins.remove');
    });
    Route::prefix('action_log_types')->group(function(){
        Route::get('/','ActionLogTypeController@index')->name('action_log_types');
        Route::get('/action_log_types/{action_log_type}','ActionLogTypeController@show')->name('action_log_types.show');
        Route::get('/create/{action_log_type}','ActionLogTypeController@create')->name('action_log_types.create');
        Route::post('/store','ActionLogTypeController@store')->name('action_log_types.store');
        Route::get('/list','ActionLogTypeController@list')->name('action_log_types.list');
        Route::get('/list/{action_log_type}','ActionLogTypeController@adminList')->name('action_log_type_admins.list');
        Route::get('/edit/{action_log_admin}','ActionLogTypeController@edit')->name('action_log_types.edit');
        Route::get('/admins_delete/{action_log_admin}', 'ActionLogTypeController@destroy')->name('action_log_types.remove');
    });
    Route::prefix('administration')->group(function(){
        Route::get('/','AdminController@index')->name('administration.users.index');
        Route::get('/list','AdminController@list')->name('administration.users.list');
        Route::get('/create','AdminController@create')->name('administration.users.create');
        Route::post('/store','AdminController@store')->name('administration.users.store');
        Route::get('/edit/{user}','AdminController@edit')->name('administration.users.edit');
        Route::get('/remove/{user}','AdminController@remove')->name('administration.users.remove');
        Route::get('/error_logs', 'JobErrorLogsController@error_logs')->name('administration.error_logs');
        Route::get('/job_status_tracker_datatables', 'JobErrorLogsController@job_status_tracker_datatables')->name('job_status_tracker_datatables');
        Route::get('/error_log_details/{error_log}', 'JobErrorLogsController@error_log_details')->name('error_log_details');
        Route::get('/run_jobs', 'JobErrorLogsController@run_jobs')->name('administration.run_jobs');
        Route::get('/run_jobs/trigger/{command}', 'JobErrorLogsController@trigger_job')->name('administration.run_jobs.trigger');
        Route::get('/master_data_history', 'MasterDataHistoryController@index')->name('administration.master_data_history');
        Route::get('/master_data_history/list', 'MasterDataHistoryController@list')->name('administration.master_data_history.list');
        Route::get('/master_data_history/view_changes/{masterDataHistory}', 'MasterDataHistoryController@viewChanges')->name('administration.master_data_history.view_changes');
    });

    Route::prefix('masterdata')->group(function(){
        Route::get('/', 'MasterDataController@index')->name('master_data_index');
        Route::get('/{section}', 'MasterDataController@general')->name('general_section');
        Route::get('refresh/{section}', 'MasterDataController@refresh')->name('refresh');
    });

    Route::prefix('shared_resources')->group(function(){
        Route::get('/','SharedResourceController@index')->name('shared_resources.index');
        Route::get('/create','SharedResourceController@create')->name('shared_resources.create');
        Route::post('/store','SharedResourceController@store')->name('shared_resources.store');
        Route::get('/list','SharedResourceController@list')->name('shared_resources.list');
        Route::get('/edit/{shared_resource}','SharedResourceController@edit')->name('shared_resources.edit');
        Route::get('/unavail/{shared_resource}','SharedResourceController@unavailResource')->name('shared_resources.unavail');
        Route::get('/avail/{shared_resource}','SharedResourceController@availResource')->name('shared_resources.avail');
        Route::get('/delete/{shared_resource}','SharedResourceController@destroy')->name('shared_resources.delete');
    });
    Route::prefix('bookings')->group(function(){
        Route::get('/','BookingController@index')->name('bookings.index');
        Route::get('/create','BookingController@create')->name('bookings.create');
        Route::post('/store','BookingController@store')->name('bookings.store');
        Route::get('/list','BookingController@list')->name('bookings.list');
        Route::get('/edit/{booking}','BookingController@edit')->name('bookings.edit');
        Route::get('/delete/{booking}','BookingController@destroy')->name('bookings.delete');
    });
    //booking_details.create
    Route::prefix('booking_details')->group(function(){
        Route::get('/create/{bookingId}','BookingDetailsController@create')->name('booking_details.create');
        Route::post('/store','BookingDetailsController@store')->name('booking_details.store');
        Route::get('/list','BookingDetailsController@list')->name('booking_details.list');
        Route::get('/edit/{booking_detail}','BookingDetailsController@edit')->name('booking_details.edit');
        Route::get('/delete/{booking_detail}','BookingDetailsController@destroy')->name('booking_details.delete');
    });

});

Route::prefix('pending-actions')->group(function(){
    Route::get('my','PendingActionController@my_pending_actions')->name('my.pending.actions');
});

Route::prefix('management-dashboards')->group(function(){
    Route::get('/{is_admin}','ManagementDashboardController@index')->name('management-dashboards');
});

Route::prefix('ed-dashboard')->group(function(){
    Route::get('/','EdDashboardController@index')->name('ed-dashboard');
});

Route::get('pm_audit_field_activities/{extra}','ManagementDashboardController@pm_audit_field_activities')->name('pm_audit_field_activities');

Route::prefix('offline')->group(function(){
    Route::get('/v3','OfflineController@index')->name('offline.index');
    Route::get('/manifest','OfflineController@manifest')->name('offline.manifest');
});