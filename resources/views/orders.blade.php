@extends('layout')

@section('content')
    <table>
        <tr>
            <th>@lang('orders.no')</th>
            <th>@lang('orders.name')</th>
            <th>@lang('orders.contact')</th>
            <th>@lang('orders.comments')</th>
            <th>@lang('orders.price')</th>
        </tr>
        @foreach ($orders as $order)
        <tr>
            <td><a href="{{ route('order',['order' => $order]) }}" >{{$order->id}}</a></td>
            <td>{{ $order->customer->name }}</td>
            <td>{{ $order->customer->contacts }}</td>
            <td>{{ $order->customer->comments }}</td>
            <td>{{ $order->total }}$</td>
        </tr>
        @endforeach
    </table>
@endsection
