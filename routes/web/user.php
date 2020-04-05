<?php

declare(strict_types=1);

Route::group([
    'middleware' => 'auth',
], function (): void {
    /*
     * User Resources Routes...
     */
    Route::resource('/users', 'Auth\ProfileController', [
        'only' => ['update', 'destroy'],
    ]);

    /*
     * User Account Settings Page.
     */
    Route::get(
        '/users/{user}/settings/{page}',
        'Auth\ProfileController@edit'
    )->name('users.edit');

    /*
     * User Password Reset Route.
     */
    Route::put(
        '/users/{user}/update/password',
        'Auth\ResetPasswordController@update'
    )->name('users.password');

    /*
     * User Notification Settings Route.
     */
    Route::put(
        '/users/{user}/update/notification',
        'Auth\NotificationController@update'
    )->name('users.notifications');

    /*
     * User Notifications Routes.
     */
    Route::get(
        '/users/{user}/notification',
        'Auth\NotificationController@index'
    )->name('users.notifications.index');

    /*
     * User Notifications Status Marked Routes.
     */
    Route::post(
        '/users/{user}/notification/raed',
        'Auth\NotificationController@markread'
    )->name('users.notifications.markread');

    /*
     * User Notifications Status Unmarked Routes.
     */
    Route::post(
        '/users/{user}/notification/unread',
        'Auth\NotificationController@markunread'
    )->name('users.notifications.markunread');

    /*
     * User Notifications Search Routes.
     */
    Route::get(
        '/users/{user}/notification/search',
        'SearchController@index'
    )->name('users.notifications.search');

    /*
     * Photo Upload Route...
     */
    Route::post(
        '/users/photo/{type?}',
        'PhotoUploadController'
    )->name('users.photo');

    /*
     * User Business Settings Route.
     */
    Route::put(
        '/users/{user}/update/business/information',
        'Auth\BusinessController@updateInformation'
    )->name('users.business.information');

    /*
     * User Business Address Settings Route.
     */
    Route::put(
        '/users/{user}/update/business/address',
        'Auth\BusinessController@updateAddress'
    )->name('users.business.address');
});
