<?php

namespace App\Http\Controllers\Client;

use App\Models\Payment;
use Stripe\Stripe;
use Stripe\Account;
use Stripe\Webhook;
use App\Models\Project;
use Stripe\AccountLink;
use Illuminate\Http\Request;
use Stripe\Checkout\Session;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

class StripeController
{

    public function createAccount(Request $request)
    {
        $user = $request->user();

        Stripe::setApiKey(env('STRIPE_SECRET'));

        if (!$user->stripe_account_id) {
            $account = Account::create([
                'type' => 'express',
                'email' => $user->email,
                'capabilities' => [
                    'card_payments' => ['requested' => true],
                    'transfers' => ['requested' => true],
                ],
            ]);

            $user->stripe_account_id = $account->id;
            $user->save();
        }


        $accountLink = AccountLink::create([
            'account' => $user->stripe_account_id,
            'refresh_url' => env('APP_HOST') . route('dashboard', [], false),
            'return_url' => env('APP_HOST') . route('dashboard', [], false),
            'type' => 'account_onboarding',
        ]);

        return redirect($accountLink->url);
    }

    public function createSession(Request $request, Project $project)
    {
        $request->validate([
            'freelancer_id' => 'required|exists:users,id',
            'amount' => 'required|integer|min:0',
        ]);

        $freelancer = \App\Models\User::find($request->freelancer_id);

        Gate::authorize('update', [Payment::class, $project, $freelancer]);

        Stripe::setApiKey(env('STRIPE_SECRET'));

        if (!$freelancer->stripe_account_id) {
            throw new BadRequestException('The freelancer does not have a Stripe account.');
        }else{
            $account = Account::retrieve($freelancer->stripe_account_id);
            if (!$account->capabilities->transfers || $account->capabilities->transfers != 'active') {
                return redirect()->back()->withErrors(['freelancer_id' => 'The freelancer does not have a Stripe account with transfer capability.']);
            }
        }

        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'usd',
                    'unit_amount' => $request->amount * 100,
                    'product_data' => [
                        'name' => $project->title,
                    ],
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => env('APP_HOST') . route('checkout.success', [$project], false),
            'cancel_url' => env('APP_HOST') . route('checkout.cancel', [$project], false),
            'payment_intent_data' => [
                'transfer_data' => [
                    'destination' => $freelancer->stripe_account_id,
                ],
            ],
        ]);

        Payment::create([
            'freelancer_id' => $freelancer->id,
            'project_id' => $project->id,
            'amount' => $request->amount,
            'status' => $session->payment_status,
            'stripe_id' => $session->id,
        ]);

        return redirect($session->url);
    }

    public function success()
    {
        return redirect(route('client.projects.payments.index'))->with('message', 'Payment successful!');
    }
    public function cancel()
    {
        return redirect(route('client.projects.payments.index'))->with('message', 'Payment canceled!');
    }

    public function handleWebhook(Request $request)
    {
        $payload = $request->getContent();
        $sig_header = $request->header('Stripe-Signature');
        $secret = env('STRIPE_WEBHOOK_SECRET');

        try {
            $event = Webhook::constructEvent($payload, $sig_header, $secret);
        } catch (\Exception $e) {
            return response('Invalid signature', 400);
        }

        if ($event->type === 'checkout.session.completed') {
            $session = $event->data->object;
            $payment = Payment::where('stripe_id', $session->id)->first();
            if ($payment) {
                $payment->update([
                    'status' => $session->payment_status,
                ]);
            }
        }

        return response('Webhook handled', 200);
    }
}
