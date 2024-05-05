<?php

declare(strict_types=1);

use App\Http\Controllers\TenantAttendanceController;
use App\Http\Controllers\TenantEventsController;
use App\Http\Middleware\TenantAdmin;
use Illuminate\Support\Facades\Route;
use Livewire\Livewire;
use Livewire\Volt\Volt;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;
use App\Http\Controllers\TenantUsersController;

/*
|--------------------------------------------------------------------------
| Tenant Routes
|--------------------------------------------------------------------------
|
| Here you can register the tenant routes for your application.
| These routes are loaded by the TenantRouteServiceProvider.
|
| Feel free to customize them however you want. Good luck!
|
*/

Route::middleware([
    'web',
    InitializeTenancyByDomain::class,
    PreventAccessFromCentralDomains::class,
])->group(function () {

    Route::get('/', function () {
        return redirect(route('tenant.login'))->with('tenant_id', tenant('id'));
    });

    Route::view('dashboard', 'dashboard')
        ->middleware(['auth', 'verified'])
        ->name('dashboard');

    Route::view('profile', 'profile')
        ->middleware(['auth'])
            ->name('profile');

    Route::middleware(['auth'])->group(function () {
        Route::resource("/users", TenantUsersController::class)->middleware(TenantAdmin::class);
        Route::resource("/events", TenantEventsController::class);
        Route::get("/attendance/start", [TenantAttendanceController::class,'start'])->name('attendance.start');
        Route::resource("/attendance", TenantAttendanceController::class);
    });

    Volt::route('/login', 'login')->name('tenant.login');

    // NOTE: this right here is crucial in making livewire components
    // be able to utilize the `tenant` helper function

    // TODO:
    // check if refactoring is possible in favor https://github.com/itsmenewbie03/org-link/pull/4
    // it currently works but the code is a bit messy
    Livewire::setUpdateRoute(function ($handle) {
        return Route::post('/livewire/update', $handle);
    });

});
