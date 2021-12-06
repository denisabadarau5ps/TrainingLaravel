@extends('layout')

@section ('content')
    <h1>@lang('general.title')</h1>
    @foreach($products as $product)
        <div class="product-container">
            <img class="product-image" src="images/{{ $product->id }}.{{ $product->extension }}"
                 alt=@lang('product.image')>
            <h3>{{ $product->title }}</h3>
            <div class="product-desc">
                {{ $product->description }}<br>
                {{ $product->price }} $
            </div>
            <a href="/?id={{ $product->id }}">@lang('buttons.add')</a>
        </div>
        <?php endforeach; ?>
        <div class="button-container">
            <div class="button-submit">
                <a href="cart.php">
                    <button> @lang('buttons.cart')</button>
                </a>
            </div>
        </div>
@endsection
