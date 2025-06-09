<?php

use App\Http\Controllers\AuthenticateController;
use App\Livewire\Auth\Attendance;
use App\Livewire\Auth\History;
use App\Livewire\Auth\Home;
use App\Livewire\Auth\Notification;
use App\Livewire\Auth\Others\Vacation;
use App\Livewire\Auth\Settings;
use App\Livewire\Auth\Settings\DevicePermission;
use App\Livewire\Auth\Settings\Email as SettingsEmail;
use App\Livewire\Auth\Settings\Password;
use App\Livewire\Auth\Settings\PersonalData;
use App\Livewire\Auth\Settings\Pin;
use App\Livewire\Auth\Settings\DeviceUuid;
use App\Livewire\Auth\Settings\FaceBiometric;
use App\Livewire\Auth\Settings\PushNotification;
use App\Livewire\Authentication\ForgotPassword;
use App\Livewire\Authentication\Login;
use App\Livewire\Authentication\RecoverPassword;
use App\Livewire\LoginWithPin;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Route;
use Minishlink\WebPush\VAPID;

Route::group(['middleware' => 'refresh_device_uuid'], function () {

    Route::get('/', Login::class);

    Route::group(['middleware' => 'verify_device_uuid'], function () {
        Route::get('/pin', LoginWithPin::class);
    });

    Route::get('/forgot-password', ForgotPassword::class);
    Route::get('/recovery-password', RecoverPassword::class);
    Route::get('/verify-email', [AuthenticateController::class, 'verify_email']);

    Route::group(['middleware' => 'verify_auth_session'], function () {
        Route::get('/remove-pages-session', [AuthenticateController::class, 'remove_page_session'])->name('remove-pages-session');
        Route::get('/add-session-page-refresh', [AuthenticateController::class, 'add_session_page_refresh'])->name('add-session-page-refresh');
        Route::get('/home', Home::class)->name('home');
        Route::get('/attendance', Attendance::class)->name('attendance');
        Route::get('/settings', Settings::class)->name('settings');
        Route::get('/history', History::class)->name('history');
        Route::get('/notification', Notification::class)->name('notification');
        Route::get('/vacation', Vacation::class)->name('vacation');

        Route::get('/settings/email', SettingsEmail::class)->name('settings/email');
        Route::get('/settings/personal-data', PersonalData::class)->name('settings/personal-data');
        Route::get('/settings/pin', Pin::class)->name('settings/pin');
        Route::get('/settings/password', Password::class)->name('settings/password');
        Route::get('/settings/device-uuid', DeviceUuid::class)->name('settings/device-uuid');
        Route::get('/settings/device-permission', DevicePermission::class)->name('settings/device-permission');
        Route::get('/settings/biometric-face', FaceBiometric::class)->name('settings/biometric-face');
        Route::get('/settings/push-notification', PushNotification::class)->name('settings/push-notification');
        Route::get('/device-uuid', function () {
            return Cookie::get(env('APP_DEVICE_UUID_COOKIES_NAME'));
        });

        Route::post('/logout', [AuthenticateController::class, 'logout'])->name('post/logout');
        Route::get('/logout', [AuthenticateController::class, 'logout'])->name('get/logout');
    });
});
