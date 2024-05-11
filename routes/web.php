<?php

use App\Mail\TenantWelcomeEmail;
use App\Models\Tenant;
use Illuminate\Support\Facades\Route;

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

Route::get('dashboard', function (\Codedge\Updater\UpdaterManager $updater) {
    if($updater->source()->isNewVersionAvailable()) {
        $versionAvailable = $updater->source()->getVersionAvailable();
        return view('dashboard', ["newVersion" => $versionAvailable,"currentVersion" => $updater->source()->getVersionInstalled()]);
    }
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::resource('/tenants', \App\Http\Controllers\TenantController::class)->middleware(['auth']);

// TEST: mail preview
Route::get("/mail", function () {
    return new TenantWelcomeEmail(new Tenant(), "deeznuts");
});

Route::get('/update', function (\Codedge\Updater\UpdaterManager $updater) {
    if($updater->source()->isNewVersionAvailable()) {
        $versionAvailable = $updater->source()->getVersionAvailable();
        $release = $updater->source()->fetch($versionAvailable);
        $updater->source()->update($release);
    } else {
        echo "No new version available.";
    }
})->middleware(['auth'])->name("update");

require __DIR__.'/auth.php';
