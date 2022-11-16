<?php

use Illuminate\Support\Facades\Route;

// --------------------------
// Custom Backpack Routes
// --------------------------
// This route file is loaded automatically by Backpack\Base.
// Routes you generate using Backpack\Generators will be placed here.

Route::group([
    'prefix'     => config('backpack.base.route_prefix', 'admin'),
    'middleware' => array_merge(
        (array) config('backpack.base.web_middleware', 'web'),
        (array) config('backpack.base.middleware_key', 'admin')
    ),
    'namespace'  => 'App\Http\Controllers\Admin',
], function () { // custom admin routes
    Route::crud('user', 'UserCrudController');
    Route::crud('role', 'RoleCrudController');
    Route::crud('permission', 'PermissionCrudController');
    Route::crud('setting', 'SettingCrudController');
    Route::crud('room', 'RoomCrudController');
    Route::crud('shift', 'ShiftCrudController');
    Route::crud('course', 'CourseCrudController');
    Route::crud('student', 'StudentCrudController');
    Route::crud('lecturer', 'LecturerCrudController');
    Route::crud('department', 'DepartmentCrudController');
    Route::crud('course-program', 'CourseProgramCrudController');
    Route::crud('student-group', 'StudentGroupCrudController');
    Route::crud('classroom', 'ClassroomCrudController');
    Route::get('charts/batch', 'Charts\BatchChartController@response')->name('charts.batch.index');
    Route::get('charts/working-hours', 'Charts\WorkingHoursChartController@response')->name('charts.working-hours.index');
}); // this should be the absolute last line of this file