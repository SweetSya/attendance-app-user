<?php

use App\Http\Controllers\AuthenticateController;
use App\Livewire\Auth\Attendance;
use App\Livewire\Auth\History;
use App\Livewire\Auth\Home;
use App\Livewire\Auth\Settings;
use App\Livewire\Authentication\ForgotPassword;
use App\Livewire\Authentication\Login;
use App\Livewire\Authentication\RecoverPassword;
use App\Livewire\LoginWithPin;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'refresh_device_uuid'], function () {

    Route::get('/', Login::class);

    Route::group(['middleware' => 'verify_device_uuid'], function () {
        Route::get('/pin', LoginWithPin::class);
    });

    Route::get('/forgot-password', ForgotPassword::class);
    Route::get('/recovery', RecoverPassword::class);

    Route::group(['middleware' => 'verify_auth_session'], function () {
        Route::get('/home', Home::class)->name('home');
        Route::get('/attendance', Attendance::class)->name('attendance');
        Route::get('/settings', Settings::class)->name('settings');
        Route::get('/history', History::class)->name('history');

        Route::get('/device-uuid', function () {
            return Cookie::get(env('APP_DEVICE_UUID_COOKIES_NAME'));
        });

        Route::post('/logout', [AuthenticateController::class, 'logout']);
    });
});
