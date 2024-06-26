<?php

use App\Mail\TenantWelcomeEmail;
use App\Models\Tenant;
use Illuminate\Support\Facades\Route;
use Salahhusa9\Updater\Facades\Updater;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::view('/', 'welcome');

Route::get("/dashboard", function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::resource('/tenants', \App\Http\Controllers\TenantController::class)->middleware(['auth']);
Route::resource('/experimentals', \App\Http\Controllers\ExperimentalFeaturesController::class)->middleware(['auth']);
// TEST: mail preview
Route::get("/mail", function () {
    return new TenantWelcomeEmail(new Tenant(), "deeznuts");
});

Route::get('update', function () {
    $update_result = Updater::update();
    session()->flash('update_result', $update_result);
    return redirect()->route('dashboard');
})->name("update");

require __DIR__.'/auth.php';
