<?php

use App\Livewire\Auth\Attendance;
use App\Livewire\Auth\History;
use App\Livewire\Auth\Home;
use App\Livewire\Auth\Settings;
use App\Livewire\Authentication\ForgotPassword;
use App\Livewire\Authentication\Login;
use App\Livewire\Authentication\RecoverPassword;
use Illuminate\Support\Facades\Route;

Route::get('/', Login::class);
Route::get('/forgot-password', ForgotPassword::class);
Route::get('/recovery', RecoverPassword::class);

Route::get('/home', Home::class)->name('home');
Route::get('/attendance', Attendance::class)->name('attendance');
Route::get('/settings', Settings::class)->name('settings');
Route::get('/history', History::class)->name('history');
