@extends('layout')

@section('content')
    <div class="login-container">
        <form method="post" action="{{ route('showStoreForm') }}" enctype="multipart/form-data">
            <input type="text" name="title" placeholder=@lang('product.title') value="{{ old('title') }}" >
            <br>
            <br>
            <textarea name="description" placeholder=@lang('product.desc') ?>{{ old('description') }}</textarea>
            <br>
            <br>
            <input type="number" name="price" placeholder=@lang('price') value="{{ old('price') }}" >
            <br>
            <br>
            <input type="file" name="fileToUpload" id="fileToUpload" style="margin-left: 20%;" >
            <br>
            <br>
            <input type="submit" name="save" value="@lang('buttons.save')"> <br><br>
            <div class="button-container">
                <a href="{{ route('products') }}" class="button">@lang('buttons.products')</a>
            </div>
        </form>
    </div>
@endsection
