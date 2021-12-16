@extends('layout')

@section ('content')
    <h1>@lang('general.cart')</h1>
    <p><b>Name: </b>{{ $order->customer->name }}</p>
    <p><b>Contacts: </b>{{ $order->customer->contacts }}</p>
    <p><b>Comments: </b>{{ $order->customer->comments }}</p>
    <h2>@lang('general.order')</h2>
    <table style="border-collapse:collapse;width:100%; border: 1px solid black; text-align: center">
        <tr style="border-bottom: 1px solid black;">
            <th>@lang('product.image')</th>
            <th>@lang('product.title')</th>
            <th>@lang('product.desc')</th>
            <th>@lang('product.price')</th>
        </tr>
        @foreach($order->products as $product)
            <tr style="border-bottom: 1px solid black;">
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
                    {{ $product->price }}$
                </td>
            </tr>
        @endforeach
    </table>
    <h2>TOTAL: {{ $order->total }}$</h2>
@endsection

