<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class WebhookController extends Controller
{
    public function handleWhatsApp(Request $request): JsonResponse
    {
        // TODO: Implement WhatsApp webhook handling
        return response()->json(['status' => 'received']);
    }

    public function handleWeChat(Request $request): JsonResponse
    {
        // TODO: Implement WeChat webhook handling
        return response()->json(['status' => 'received']);
    }
}
