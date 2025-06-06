<?php

use App\Http\Controllers\JobListingController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SellerController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;




Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
 Route::resource('roles', RoleController::class)->middleware('auth');
Route::resource('users', UserController::class);
Route::resource('permissions', PermissionController::class)->middleware('auth');
Route::resource('job-listings', JobListingController::class);

// web.php

Route::post('/job-listings/{jobListing}/apply', [JobListingController::class, 'apply'])->name('jobs.apply');

Route::get('/applications', [JobListingController::class, 'appliedJobs'])->name('jobs.applied_jobs');
require __DIR__.'/auth.php';
