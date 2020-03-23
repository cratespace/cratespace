<?php

use Illuminate\Support\Facades\Route;

Route::get('/coming-soon', function () {
    return view('coming-soon');
})->name('coming_soon');

/**
 * Public Routes...
 */
Route::group([
    'middleware' => 'guest'
], function () {
    /**
     * Carrier's Page...
     */
    Route::get('/carrier', function () {
        return view('carrier');
    })->name('carrier');

    /**
     * Support & FAQ Page...
     */
    Route::get('/support', function () {
        return view('support');
    })->name('support');

    /**
     * Privacy Policy Page...
     */
    Route::get('/privacy', function () {
        return view('privacy');
    })->name('privacy');

    /**
     * Privacy Policy Page...
     */
    Route::get('/pricing', function () {
        return view('pricing');
    })->name('pricing');

    /**
     * Contact Page...
     */
    Route::get('/contact', function () {
        return view('contact');
    })->name('messages.create');

    /**
     * Client Message Route...
     */
    Route::post('/contact', 'MessageController')->name('messages.store');

    /**
     * Checkout Routes...
     */
    Route::group([
        'prefix' => 'checkout'
    ], function () {
        /**
         * Checkout Page...
         */
        Route::get('/', 'CheckoutController@show')->name('checkout');

        /**
         * Checkout Page...
         */
        Route::get('/', 'CheckoutController@show')->name('checkout');

        /**
         * Purchase Route...
         */
        Route::post('/{space}', 'CheckoutController@store')
            ->name('checkout.store');

        /**
         * Cancel Purchase Route...
         */
        Route::get('/destroy', 'CheckoutController@destroy')
            ->name('checkout.destroy');
    });

    /**
     * Listings Page...
     */
    Route::get('/', 'ListingsController')->name('listings');

    /**
     * Place Order Route...
     */
    Route::post('/orders', 'OrderController@store')->name('orders.store');
});

/**
 * Auth Routes...
 */
Auth::routes();

/**
 * Auth Business Routes...
 */
Route::group([
    'middleware' => ['auth', 'business'],
], function () {
    /**
     * Dashboard...
     */
    Route::get('/home', 'HomeController')->name('home');

    /**
     * Spaces Routes...
     */
    Route::resource('/spaces', 'SpaceController');
});

/**
 * Users Routes...
 */
Route::group([
    'middleware' => 'auth',
], function () {
    /**
     * User Resources Routes...
     */
    Route::resource('/users', 'Auth\ProfileController', [
        'except' => ['create', 'store', 'edit']
    ]);

    /**
     * User Account Settings Page.
     */
    Route::get(
        '/users/{user}/settings/{page}',
        'Auth\ProfileController@edit'
    )->name('users.edit');

    /**
     * User Password Reset Route.
     */
    Route::put(
        '/users/{user}/update/password',
        'Auth\ResetPasswordController@update'
    )->name('users.password');

    /**
     * User Notification Settings Route.
     */
    Route::put(
        '/users/{user}/update/notification',
        'Auth\NotificationController@update'
    )->name('users.notifications');

    /**
     * Photo Upload Route...
     */
    Route::post(
        '/users/photo/{profile?}',
        'PhotoUploadController'
    )->name('users.photo');

    /**
     * User Business Settings Route.
     */
    Route::put(
        '/users/{user}/update/business/information',
        'Auth\BusinessController@updateInformation'
    )->name('users.business.information');

    /**
     * User Business Address Settings Route.
     */
    Route::put(
        '/users/{user}/update/business/address',
        'Auth\BusinessController@updateAddress'
    )->name('users.business.address');
});

/**
 * Admin Routes...
 */
Route::group([
    'middleware' => ['auth', 'admin'],
], function () {
    /**
     * Admin Dashboard...
     */
    Route::get('/admin', 'Admin\HomeController')->name('admin');
});
