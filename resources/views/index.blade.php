@extends('layout')

@section ('content')
    <h1>@lang('general.title')</h1>
    @foreach($products as $product)
        <div class="product-container">
            @include('product')
            <a href="/?id={{ $product->id }}">@lang('buttons.add')</a>
        </div>
    @endforeach
    <div class="button-container">
            <div class="button-submit">
                <a href="/cart">
                    <button> @lang('buttons.cart')</button>
                </a>
            </div>
        </div>
@endsection
