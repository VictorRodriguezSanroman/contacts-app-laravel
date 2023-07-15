<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StripeController extends Controller
{
    public function checkout(Request $request)
    {
        return $request->user()
            ->newSubscription('default', config('stripe.price_id'))
            ->checkout();
    }

    public function billing(Request $request)
    {
        return $request->user()->redirectToBillingPortal();
    }

    public function freeTrialend()
    {
        return view('free-trial-ends');
    }
}
