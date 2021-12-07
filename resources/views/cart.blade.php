@extends('layout')

@section ('content')
    <h1>@lang('general.cart')</h1>
    @foreach($products as $product)
        <div class="product-container">
            @include('product')
            <a href="/cart?id={{ $product->id }}">@lang('buttons.remove')</a>
        </div>
    @endforeach
        @include('form')
        <div class="button-container">
            <div class="button-submit">
                <a href="/">
                    <button>@lang('buttons.index')</button>
                </a>
            </div>
        </div>
@endsection
