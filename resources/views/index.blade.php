@extends('layout')

@section ('content')
    <h1>@lang('general.title')</h1>
    @foreach($products as $product)
        <form method="post" action="{{ route('add.to.cart') }}">
            @csrf
            <input type="hidden" id="id" name="id" value="{{ $product->id }}">
            <div class="product-container">
                @include('product')
                <button type="submit" value="add">@lang('buttons.add')</button>
            </div>
        </form>
        <?php endforeach; ?>
        <div class="button-container">
            <div class="button-submit">
                <a href="/cart">
                    <button> @lang('buttons.cart')</button>
                </a>
            </div>
        </div>
@endsection
