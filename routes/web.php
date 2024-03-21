<?php

use App\Http\Controllers\CouponController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\CoursePurchaseController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;

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

// disable Register Route
// Auth::routes(['register' => false]);

Route::group(['middleware' => 'web'], function(){


    // Dashboard Back-end Routes
    Route::group(['controller' => HomeController::class], function () {
        Route::get('/', 'index');
        Route::get('dashboard', 'dashboard')->middleware(['auth', 'verified'])->name('dashboard');
    });
    
    // Profile Back-end Routes
    Route::group(['controller' => ProfileController::class], function(){
        Route::get('profile', 'index')->middleware(['auth'])->name('profile');
    });

    // Setting Controller
    Route::group(['controller' => SettingController::class], function(){
        Route::get('profile/setting', 'index')->name('profile.setting');
    });

    // Resource Controller
    Route::resources([
        'user' => UserController::class,
        'role' => RoleController::class,
        'course' => CourseController::class,
        'purchase' => CoursePurchaseController::class,
        'coupon' => CouponController::class,
    ]);
    
});

/**
 * Require the routes defined in auth.php. This separates authentication 
 * routes into their own file.
 */
require __DIR__ . '/auth.php';