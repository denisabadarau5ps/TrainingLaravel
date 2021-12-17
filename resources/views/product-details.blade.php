@extends('layout')

@section('content')
    <div class="order-container">
        @if (session('status'))
            <p class="status">{{session('status')}}</p>
        @endif
        @include('product')
        <br>
        <div class="rating">
            <form method="post" action="{{route('store.rating')}}">
                @csrf
                <input type="hidden" name="id" id="id" value="{{$product->id}}">
                <label for="rating">Rating:</label>
                <select name="rating" id="rating">
                    @foreach([1,2,3,4,5] as $rate)
                        <option value="{{$rate}}" {{ old('rating') == $rate ? 'selected' : ''}}>{{$rate}}</option>
                    @endforeach
                </select>
                <br>
                @error('rating')
                <p class="error-message">{{$message}}</p>
                @enderror
                <br>
                <input type="text" name="cname" id="cname" placeholder="@lang('customer.name')"
                       value="{{old('cname')}}">
                <br>
                @error('cname')
                <p class="error-message">{{$message}}</p>
                @enderror
                <br>
                <textarea name="comment" id="comment"
                          placeholder="@lang('customer.comments')">{{old('comment')}}</textarea>
                <br>
                @error('comment')
                <p class="error-message">{{$message}}</p>
                @enderror
                <br>
                <input type="submit" value="@lang('buttons.rating')">
            </form>
        </div>
        <br>
        @if ($product->ratings != [])
            <div class="ratings">
                <h2>@lang('general.reviews')</h2>
                @foreach($product->ratings as $rating)
                    <div class="rate">
                        <p><b>{{$rating->name}}: </b><span>{{$rating->comment}}</span></p>
                        <p><b>Rating: </b>{{$rating->rating}}</p>
                    </div>
                @endforeach
            </div>
        @endif
        <br>
        <a href="{{ route('index') }}" class="button-products"> @lang('buttons.index')</a>
    </div>
@endsection
