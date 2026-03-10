<?php

use App\Http\Controllers\Api\WebhookController;
use Illuminate\Support\Facades\Route;

Route::post('/webhooks/whatsapp', [WebhookController::class, 'handleWhatsApp'])
    ->name('webhooks.whatsapp');

Route::post('/webhooks/wechat', [WebhookController::class, 'handleWeChat'])
    ->name('webhooks.wechat');
