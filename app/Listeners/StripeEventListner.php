<?php

namespace App\Listeners;

use App\Models\User;
use Laravel\Cashier\Events\WebhookHandled;
use App\Notifications\SubscriptionCompleteNotification;

class StripeEventListner
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(WebhookHandled $event): void
    {
        if (
            $event->payload['type'] === 'customer.subscription.updated'
            && $event->payload['data']['previous_attributes']['status'] === 'incomplete'
            && $event->payload['data']['object']['status'] === 'active'
        ) {
            $user = User::where('stripe_id', $event->payload['data']['object']['customer'])->first();
            $user->notify(new SubscriptionCompleteNotification($user->name));
        }
    }
}
