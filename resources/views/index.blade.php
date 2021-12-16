@extends('layout')

@section ('content')
    <h1>@lang('general.title')</h1>
    @foreach($products as $product)
        <div class="product-container">
            @include('product')
            <form method="post" action="{{ route('add.to.cart') }}">
                @csrf
                <input type="hidden" id="id" name="id" value="{{ $product->id }}">
                <button type="submit" value="add" class="button-products">@lang('buttons.add')</button>
            </form>
            <br>
            <a href="{{route('show.product', ['id' => $product->id])}}" class="button-products">@lang('buttons.details')</a>
        </div>
    @endforeach
    <div class="button-container">
        <a href="{{ route('show.cart') }}" class="button"> @lang('buttons.cart')</a>
    </div>
@endsection
