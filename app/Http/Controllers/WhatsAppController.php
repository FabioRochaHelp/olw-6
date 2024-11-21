<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\UserServices;
use App\Services\StripeServices;
use Illuminate\Http\Request;

class WhatsAppController extends Controller
{
    public function __construct(protected UserServices $userServices, protected StripeServices $stripeService) {}

    public function new_message(Request $request)
    {
        $phone = "+" . $request->post('WaId');

        $user = User::where('phone', $phone)->first();

        if (!$user) {
            $user = $this->userServices->store($request->all());
        }

        if (!$user->subscribed()) {
            $this->stripeService->payment($user);
        }
    }
}
