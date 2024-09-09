<?php

use App\Livewire\Auth\Home;
use App\Livewire\Authentication\ForgotPassword;
use App\Livewire\Authentication\Login;
use App\Livewire\Authentication\RecoverPassword;
use Illuminate\Support\Facades\Route;

Route::get('/', Login::class);
Route::get('/forgot-password', ForgotPassword::class);
Route::get('/recovery', RecoverPassword::class);

Route::get('/home', Home::class);
