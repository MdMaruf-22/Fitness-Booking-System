@extends('layouts.app')

@section('title', 'Payment for Booking')

@section('header')
<h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
    Payment for Booking: {{ $class->title }}
</h2>
@endsection

@section('content')
@php
$methods = [
[
'id' => 'card',
'label' => 'card',
'img' => 'assets/card.png',
'ring' => 'indigo',
],
[
'id' => 'bkash',
'label' => 'bKash',
'img' => 'assets/bkash.png',
'ring' => 'pink',
],
[
'id' => 'nagad',
'label' => 'Nagad',
'img' => 'assets/nagad.png',
'ring' => 'red',
],
[
'id' => 'rocket',
'label' => 'Rocket',
'img' => 'assets/rocket.png',
'ring' => 'purple',
],
];
@endphp

<div x-data="{ loading: false }" class="py-8 relative">

    {{-- Loading Overlay --}}
    <div x-show="loading" x-transition
        class="fixed inset-0 bg-black/60 backdrop-blur flex flex-col justify-center items-center z-50">
        <svg class="animate-spin h-12 w-12 text-white mb-4" xmlns="http://www.w3.org/2000/svg" fill="none"
            viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
        </svg>
        <p class="text-white text-lg font-semibold">Processing Payment...</p>
    </div>

    <div class="max-w-xl mx-auto px-4">
        <div class="bg-white/80 dark:bg-gray-800/80 backdrop-blur rounded-2xl shadow-xl p-8 space-y-8">

            <div>
                <h3 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-2">Confirm Your Payment</h3>
                <p class="text-sm text-gray-600 dark:text-gray-300 mb-4">
                    Complete your booking for <strong>{{ $class->title }}</strong>.
                </p>

                <div class="bg-gray-100 dark:bg-gray-700 p-4 rounded-lg">
                    <div class="flex justify-between mb-2">
                        <span>Class Price</span>
                        <span>৳{{ number_format($class->price, 2) }}</span>
                    </div>
                    <div class="flex justify-between text-sm text-gray-500">
                        <span>VAT & Charges</span>
                        <span>Included</span>
                    </div>
                </div>
            </div>

            <form action="{{ route('payments.confirm', $class->id) }}" method="POST" @submit="loading = true">
                @csrf

                <div class="space-y-4">

                    <label class="block text-lg font-medium text-gray-700 dark:text-gray-300">
                        Choose Payment Method
                    </label>

                    <div x-data="{ selected: '' }" class="grid grid-cols-2 gap-4">
                        @foreach ($methods as $method)
                        <input type="radio" id="{{ $method['id'] }}" name="payment_method"
                            value="{{ $method['id'] }}" class="hidden"
                            x-model="selected" required>

                        <label for="{{ $method['id'] }}"
                            :class="selected === '{{ $method['id'] }}'
                        ? 'ring-2 ring-{{ $method['ring'] }}-500 scale-105'
                        : 'opacity-60 hover:ring-2 hover:ring-{{ $method['ring'] }}-300'"
                            class="flex items-center justify-center cursor-pointer p-4 rounded-xl bg-gray-100 dark:bg-gray-700 transition duration-200">
                            <img src="{{ asset($method['img']) }}" alt="{{ $method['label'] }}" class="h-10">
                        </label>
                        @endforeach
                    </div>


                    <div>
                        <label for="amount_paid" class="block text-lg font-medium text-gray-700 dark:text-gray-300">
                            Enter Amount
                        </label>
                        <input type="number" name="amount_paid" id="amount_paid" min="1" step="0.01"
                            placeholder="৳ Amount" required
                            class="mt-1 block w-full px-4 py-3 rounded-lg border-gray-300 dark:border-gray-600 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100">
                    </div>

                    <button type="submit"
                        class="w-full py-3 rounded-xl bg-indigo-600 text-white font-semibold hover:bg-indigo-700 transition shadow-lg">
                        Confirm Payment
                    </button>

                    <p class="text-center text-xs text-gray-500 mt-2">
                        Your payment is secure & encrypted.
                    </p>

                </div>
            </form>

        </div>
    </div>
</div>
@endsection