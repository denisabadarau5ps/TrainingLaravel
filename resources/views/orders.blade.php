@extends('layout')

@section('content')
    <table>
        <tr>
            <th>@lang('orders.no')</th>
            <th>@lang('orders.customer')</th>
            <th>@lang('orders.date')</th>
            <th>@lang('orders.price')</th>
            <th>@lang('orders.products')</th>
        </tr>
        @foreach ($orders as $order)
        <tr>
            <td>{{ $order->id }}</td>
            <td>{{ $order->customer->name }}</td>
            <td>{{ $order->created_at }}</td>
            <td>{{ $order->total }}$</td>
            <td>
                <ul>
                    @foreach ($order->products as $product)
                        <li>{{ $product->title }}</li>
                    @endforeach
                </ul>
            </td>
        </tr>
        @endforeach
    </table>
@endsection
