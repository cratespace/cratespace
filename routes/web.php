<?php

use Inertia\Inertia;
use App\Models\Invitation;
use Illuminate\Http\Request;
use App\Mail\BusinessInvitation;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Business\SpaceController;
use App\Http\Controllers\Business\BusinessController;
use App\Http\Controllers\Business\InviteBusinessController;
use App\Http\Controllers\Auth\UpdateUserAddressInformationController;
use App\Http\Controllers\Business\OrderController as BusinessOrderController;
use App\Http\Controllers\Customers\OrderController as CustomerOrderController;

Route::get('/', function (Request $request) {
    return Inertia::render('Welcome/Show');
})->name('welcome');

Route::group([
    'middleware' => ['auth:sentinel', 'verified'],
], function (): void {
    Route::put('/user/address', [UpdateUserAddressInformationController::class, '__invoke'])->name('user.address');

    Route::post('/orders/{product}', [CustomerOrderController::class, 'store'])->name('orders.store');
    Route::delete('/orders', [CustomerOrderController::class, 'destroy'])->name('orders.destroy');

    Route::group([
        'middleware' => ['business'],
    ], function (): void {
        Route::get('/home', fn () => Inertia::render('Business/Home'))->name('home');
        Route::get('/businesses', [BusinessController::class, 'create'])->name('business.create');
        Route::post('/businesses', [BusinessController::class, 'store'])->name('business.store');
        Route::post('/businesses/invite/{user}', [InviteBusinessController::class, 'store'])->name('business.invite');

        Route::resource('spaces', SpaceController::class);
        Route::get('/orders/{order}', [BusinessOrderController::class, 'show'])->name('orders.show');
    });
});

Route::group([
    'middleware' => 'signed',
], function (): void {
    Route::get('/businesses/{invitation}', [InviteBusinessController::class, 'update'])->name('invitations.accept');
});

/*
 * Testing Routes...
 */
Route::get('/mailable', function () {
    $invitation = Invitation::find(1);

    return new BusinessInvitation($invitation);
});
