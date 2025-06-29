@extends('client.projects.layout', ['current' => 'payments'])

@section('main-content')
    <h1 class="text-4xl font-sans text-center">{{ __('payments') }}</h1>
    @can('create', [App\Models\Payment::class, $project])
        <a href="{{ route('client.projects.payments.create', $project) }}" class="text-blue-500 underline text-xl px-2">{{ __('new-payment') }}</a>
    @endcan
    <flux:separator />
    <div class="flex flex-col gap-5 p-10">
        @foreach ($payments as $payment)
            <div class="bg-[#1d1d20] space-y-2 rounded-lg p-3">
                <div class="flex h-full gap-3 items-center">
                    <flux:icon.user-plus class="size-20" />
                    <div class="space-y-2 grow">
                        <a href="{{ route('profile.show', $payment->freelancer) }}">
                            <flux:heading>{{ $payment->freelancer->name }}</flux:heading>
                        </a>
                        <flux:text>{{ $payment->freelancer->email }}</flux:text>
                        <div class="flex gap-3">
                            <flux:badge>${{ $payment->amount }}</flux:badge>
                            <flux:badge :color="$payment->status == 'paid' ? 'green' : 'yellow'">{{ $payment->status }}</flux:badge>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
