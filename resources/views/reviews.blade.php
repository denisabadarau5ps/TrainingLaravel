@extends('layout')

@section('content')
    <h1>@lang('general.reviews')</h1>
    <table>
        <tr>
            <th>No</th>
            <th>Customer</th>
            <th>Comment</th>
            <th>Rating</th>
            <th>Option</th>
        </tr>
        @foreach($ratings as $rating)
            <tr>
                <td>{{$rating->id}}</td>
                <td>{{$rating->name}}</td>
                <td>{{$rating->comment}}</td>
                <td>{{$rating->rating}}</td>
                <td>
                    <form method="post" action="{{ route('approve.rating')}}">
                        @csrf
                        <input type="hidden" id="id" name="id" value="{{ $rating->id }}">
                        <input type="submit" name="delete" id="approve" value="@lang('buttons.approve')">
                    </form>
                    <br>
                    <form method="post" action="{{ route('reject.rating')}}">
                        @csrf
                        <input type="hidden" id="id" name="id" value="{{ $rating->id }}">
                        <input type="submit" name="delete" id="reject" value="@lang('buttons.reject')">
                    </form>
                </td>
            </tr>
        @endforeach
    </table>
@endsection
