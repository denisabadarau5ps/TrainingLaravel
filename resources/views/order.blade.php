@extends('layout')

@section('content')
    <div class="order-container">
        <h1>{{ $order->customer->name }}, your order is: </h1>
        @foreach ($order->products as $product)
        <div class="order-product-container">
            @include('product')
        </div>
        @endforeach
        <p><b>Contact details</b>: {{ $order->customer->contacts }}</p>
        <p><b>Total</b>: {{ $order->total }}$</p>
        <a href="{{ route('index') }}" class="button-products">@lang('buttons.index')</a>
    </div>
@endsection

