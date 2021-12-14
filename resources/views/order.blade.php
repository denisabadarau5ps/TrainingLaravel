@extends('layout')

@section('content')
    <div class="order-container">
        <h1>Order #{{ $order->id }} </h1>
        <h3>Created at: {{ $order->created_at }}</h3>
        <table style="border-collapse:collapse;width:100%; border: 1px solid black; text-align: center">
            <tr style="border-bottom: 1px solid black;">
                <th>@lang('product.image')</th>
                <th>@lang('product.title')</th>
                <th>@lang('product.desc')</th>
                <th>@lang('product.price')</th>
            </tr>
            @foreach($order->products as $product)
                <tr>
                    <td>
                        <img height="100" width="100"
                             src="{{ url('storage/images/'.$product->id . '.' . $product->extension) }}"
                             alt=@lang('product.image')>
                    </td>
                    <td>
                        {{ $product->title }}
                    </td>
                    <td>
                        {{ $product->description }}<br>
                    </td>
                    <td>
                        {{ $product->pivot->product_price }}$
                    </td>
                </tr>
            @endforeach
        </table>
        <br>
        <a href="{{ route('orders') }}" class="button-products">@lang('buttons.orders')</a>
    </div>
@endsection

