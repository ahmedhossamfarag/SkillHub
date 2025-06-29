@extends('client.projects.layout', ['current' => 'payments'])

@section('main-content')
    <h1 class="text-4xl font-sans text-center">{{ __('new-payment') }}</h1>
    <flux:separator />
    <div class="p-10">
        <form action="{{ route('checkout.create', $project) }}" method="POST" class="space-y-5">
            @csrf
            <flux:select name="freelancer_id" label="{{ __('freelancer') }}" required>
                <option value="" disabled selected>{{ __('freelancer') }}</option>
                @foreach ($freelancers as $freelancer)
                    <option value="{{ $freelancer->id }}">{{ $freelancer->name }} - {{ $freelancer->email }}</option>
                @endforeach
            </flux:select>
            <flux:input name="amount" type="number" min="0" label="{{ __('amount') }}" placeholder="{{ __('amount') }}" value="{{ old('amount') }}" required></flux:input>
            <flux:button variant="primary" type="submit" color="blue" class="w-full cursor-pointer">{{ __('continue') }}</flux:button>
        </form>
    </div>
@endsection