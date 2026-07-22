<?php

namespace App\Http\Controllers;

use App\Services\MidtransService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MidtransWebhookController extends Controller
{
    public function handle(Request $request)
    {
        $payload = $request->all();
        Log::info('Midtrans Webhook', $payload);

        try {
            app(MidtransService::class)->handleNotification($payload);

            return response()->json(['status' => 'ok']);
        } catch (\Exception $e) {
            Log::error('Webhook Error: '.$e->getMessage());

            return response()->json(['status' => 'error'], 500);
        }
    }
}
