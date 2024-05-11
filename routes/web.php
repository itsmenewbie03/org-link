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

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::resource('/tenants', \App\Http\Controllers\TenantController::class)->middleware(['auth']);

// TEST: mail preview
Route::get("/mail", function () {
    return new TenantWelcomeEmail(new Tenant(), "deeznuts");
});

Route::get('/update', function (\Codedge\Updater\UpdaterManager $updater) {

    // Check if new version is available
    if($updater->source()->isNewVersionAvailable()) {

        // Get the current installed version
        echo $updater->source()->getVersionInstalled();

        // Get the new version available
        $versionAvailable = $updater->source()->getVersionAvailable();

        // Create a release
        $release = $updater->source()->fetch($versionAvailable);

        // Run the update process
        $updater->source()->update($release);

    } else {
        echo "No new version available.";
    }

})->middleware(['auth']);

require __DIR__.'/auth.php';
