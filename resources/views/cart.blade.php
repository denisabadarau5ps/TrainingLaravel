@extends('layout')

@section ('content')
    @if (session('message'))
        <div class="error-message">
            <p>{{ session('message') }}</p>
        </div>
    @endif
    <table>
        <tr>
            <th>Product</th>
            <th>Title</th>
            <th>Description</th>
            <th>Price</th>
            <th>Options</th>
        </tr>
        @foreach($products as $product)
            <tr>
                <td>
                    <img class="product-image" src="{{ url('storage/images/'.$product->id . '.' . $product->extension) }}" alt=@lang('product.image')>
                </td>
                <td> {{ $product->title }} </td>
                <td> {{ $product->description }} </td>
                <td> {{ $product->price }}$ </td>
                <td>
                    <form method="post" action="{{ route('remove.from.cart') }}">
                        @csrf
                        <input type="hidden" id="id" name="id" value="{{ $product->id }}">
                        <button type="submit" value="remove">@lang('buttons.remove')</button>
                    </form>
                </td>
            </tr>
    @endforeach
    </table>
    @include('checkout-form')
    <div class="button-container">
        <a href="{{ route('index') }}">
            <button class="btn"> @lang('buttons.index') </button>
        </a>
    </div>
@endsection
