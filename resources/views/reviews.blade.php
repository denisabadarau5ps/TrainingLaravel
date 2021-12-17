@extends('layout')

@section('content')
    <h1>@lang('general.reviews')</h1>
    <table>
        <tr>
            <th>No</th>
            <th>Product</th>
            <th>Customer</th>
            <th>Comment</th>
            <th>Rating</th>
            <th>Option</th>
        </tr>
        @foreach($ratings as $rating)
            <tr>
                <td>{{$rating->id}}</td>
                <td>
                    <a href="{{route('show.product', ['id' => $rating->product->id])}}">
                        {{$rating->product->title}}
                    </a>
                </td>
                <td>{{$rating->name}}</td>
                <td>{{$rating->comment}}</td>
                <td>{{$rating->rating}}</td>
                <td>
                    <form method="post" action="{{ route('approve.rating')}}">
                        @csrf
                        <input type="hidden" id="id" name="id" value="{{ $rating->id }}">
                        <input type="submit" name="approve" id="approve" value="@lang('buttons.approve')">
                    </form>
                    <br>
                    <form method="post" action="{{ route('reject.rating')}}">
                        @csrf
                        <input type="hidden" id="id" name="id" value="{{ $rating->id }}">
                        <input type="submit" name="reject" id="reject" value="@lang('buttons.reject')">
                    </form>
                </td>
            </tr>
        @endforeach
    </table>
@endsection
