@extends('layout')

@section('content')
    <div class="login-container">
        <h1>@lang('general.edit')</h1>
        @if (session('status'))
            <p class="status">{{ session('status') }}</p>
        @endif
        <form method="post" action="{{ route('edit', ['product' => $product]) }}" enctype="multipart/form-data">
            @csrf
            <input type="text" name="title" placeholder=@lang('product.title') value="{{ $product->title }}" >
            <br>
            @error('title')
            <p class="error-message">{{ $message }}</p>
            @enderror
            <br>
            <textarea name="description" placeholder=@lang('product.desc') ?>{{ $product->description }}</textarea>
            <br>
            @error('description')
            <p class="error-message">{{ $message }}</p>
            @enderror
            <br>
            <input type="number" name="price" placeholder=@lang('product.price') value="{{ $product->price }}" >
            <br>
            @error('price')
            <p class="error-message">{{ $message }}</p>
            @enderror
            <br>
            <input type="file" name="fileToUpload" id="fileToUpload">
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
