@extends('layout')

@section ('content')
    <h1>@lang('general.cart')</h1>
    @if (session('message'))
        <div class="error-message">
            <p>{{ session('message') }}</p>
        </div>
    @endif
    @foreach($products as $product)
        <div class="product-container">
            @include('product')
            <form method="post" action="{{ route('remove.from.cart') }}">
                @csrf
                <input type="hidden" id="id" name="id" value="{{ $product->id }}">
                <button type="submit" value="remove">@lang('buttons.remove')</button>
            </form>
        </div>
    @endforeach
    @include('checkout-form')
    <div class="button-container">
        <a href="{{ route('index') }}" class="button"> @lang('buttons.index')</a>
    </div>
@endsection
