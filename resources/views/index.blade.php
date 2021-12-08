@extends('layout')

@section ('content')
    <h1>@lang('general.title')</h1>
    @foreach($products as $product)
        <form method="post" action="{{ route('index') }}">
            @csrf
            <input type="hidden" id="id" name="id" value="{{ $product->id }}">
            <div class="product-container">
                @include('product')
                <button type="submit" value="add">@lang('buttons.add')</button>
            </div>
        </form>
    @endforeach
    <div class="button-container">
        <a href="{{ route('cart') }}" class="button"> @lang('buttons.cart')</a>
    </div>
@endsection
