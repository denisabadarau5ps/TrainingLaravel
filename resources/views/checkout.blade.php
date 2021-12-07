@extends('layout')

@section ('content')
    <h1>@lang('general.cart')</h1>
    <p><b>Name: </b>{{ $name }}</p>
    <p><b>Contacts: </b>{{ $contacts }}</p>
    <p><b>Comments: </b>{{ $comments }}</p>
    @foreach($products as $product)
        <div class="product-container">
            <img class="product-image" src="{{ $message->embed(public_path() . '/images/' . $product->id .'.'. $product->extension ) }}" alt=@lang('product.image')>
            <h3>{{ $product->title }}</h3>
            <div class="product-desc">
                {{ $product->description }}<br>
                {{ $product->price }} $
            </div>
        </div>
    @endforeach
@endsection

