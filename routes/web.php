<?php

use App\Http\Controllers\CourseCategoryController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\CoursePurchaseController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BkashPaymentController;
use App\Http\Controllers\LinkController;

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
        Route::get('user/profile/{id}', 'user_profile')->middleware(['auth'])->name('user.profile');
    });
    
    // Course Category Back-end Routes
    Route::group(['controller' => CourseCategoryController::class], function(){
        Route::get('/course/category', 'index')->middleware(['auth'])->name('category');
    });

    // Setting Controller
    Route::group(['controller' => SettingController::class], function(){
        Route::get('profile/setting', 'index')->name('profile.setting');
    });

    
    // Add Social Media Links Routes
    Route::group(['middleware'=> 'admin','controller' => LinkController::class], function(){
        Route::get('/links', 'index')->name('link');
    });


    // Resource Controller For All
    Route::resources([
        'course' => CourseController::class,
    ]);

    // Resourse Controller For Only Admin
    Route::group(['middleware' => 'admin'], function(){
        Route::resources([
            'user' => UserController::class,
            'role' => RoleController::class,
            'purchase' => CoursePurchaseController::class,
            'coupon' => CouponController::class, 
        ]);
    });

    // Bkash Routes
    Route::group(['middleware' => ['auth'], 'controller' => BkashPaymentController::class], function () {
        // Payment Routes for bKash
        Route::get('/bkash/payment', 'index');
        Route::post('/bkash/get-token', 'getToken')->name('bkash-get-token');
        Route::post('/bkash/create-payment', 'createPayment')->name('bkash-create-payment');
        Route::post('/bkash/execute-payment', 'executePayment')->name('bkash-execute-payment');
        Route::get('/bkash/query-payment', 'queryPayment')->name('bkash-query-payment');
        Route::post('/bkash/success', 'bkashSuccess')->name('bkash-success');
        // Refund Routes for bKash
        Route::get('/bkash/refund', 'refundPage')->name('bkash-refund');
        Route::post('/bkash/refund', 'refund')->name('bkash-refund');
    });
});

/**
 * Require the routes defined in auth.php. This separates authentication 
 * routes into their own file.
 */
require __DIR__ . '/auth.php';