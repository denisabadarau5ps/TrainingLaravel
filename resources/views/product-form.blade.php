@extends('layout')

@section('content')
    <div class="login-container">
        <h1>@lang('general.product')</h1>
        @if (session('status'))
            <p class="status">{{ session('status') }}</p>
        @endif
        <form method="post" action="{{ route('store', ['id' => $id]) }}" enctype="multipart/form-data">
            @csrf
            <input
                type="text"
                name="title"
                placeholder=@lang('product.title')
                    value="{{  $product ?  $product->translateAttribute('name') : old('title') }}"
            >
            <br>
            @error('title')
                <p class="error-message">{{ $message }}</p>
            @enderror
            <br>
            <textarea
                name="description"
                placeholder=@lang('product.desc')>{{$product ? $product->translateAttribute('description'): old('description') }}</textarea>
            <br>
            @error('description')
                <p class="error-message">{{ $message }}</p>
            @enderror
            <br>
            <input
                type="number"
                name="price"
                placeholder=@lang('product.price')
                    value="{{ $product ? $product->variants->pluck('prices')->flatten()->sortBy('price')->first()->price : old('price')}}">
            <br>
            @error('price')
                <p class="error-message">{{ $message }}</p>
            @enderror
            <br>
            <input type="file" name="filename" id="filename" style="margin-left: 20%;">
            <br>
            @error('fileToUpload')
                <p class="error-message">{{ $message }}</p>
            @enderror
            <br>
            <input type="submit" name="save" value="@lang('buttons.save')"> <br><br>
            <a href="{{ route('products') }}" class="button-products">@lang('buttons.products')</a>
        </form>
    </div>
@endsection
