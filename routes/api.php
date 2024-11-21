<?php

use App\Http\Controllers\WhatsAppController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/new_message', [WhatsAppController::class, 'new_message'])
->middleware(\App\Http\Middleware\TwilioRequestMiddleware::class)
->name('new_message');
Route::get('/callback', [WhatsAppController::class, 'callback'])->name('callback');
