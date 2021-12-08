@extends('layout')

@section ('content')
    <h1>@lang('general.cart')</h1>
    @if (session('message'))
        <div class="error-message">
            <p>{{ session('message') }}</p>
        </div>
    @endif
    @foreach($products as $product)
        <form method="post" action="{{ route('cart') }}">
            @csrf
            <input type="hidden" id="id" name="id" value="{{ $product->id }}">
            <div class="product-container">
                @include('product')
                <button type="submit" value="remove">@lang('buttons.remove')</button>
            </div>
        </form>
    @endforeach
        @include('form')
        <div class="button-container">
            <a href="{{ route('index') }}" class="button"> @lang('buttons.index')</a>
        </div>
@endsection
