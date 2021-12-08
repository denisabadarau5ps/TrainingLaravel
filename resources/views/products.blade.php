@extends('layout')

@section('content')
    <h1>@lang('general.products')</h1>
    @foreach($products as $product)
        <form method="post" action="{{ route('deleteProducts') }}">
            @csrf
            <input type="hidden" id="id" name="id" value="{{ $product->id }}">
            <div class="product-container">
                @include('product')
                <input type="submit" name="edit" value="@lang('buttons.edit')">
                <input type="submit" name="delete" value="@lang('buttons.delete')">
            </div>
        </form>
    @endforeach
    <div class="button-container">
        <a href="{{ route('showStoreForm') }}" class="button"> @lang('buttons.add')</a>
    </div>
    <br>
    <div class="button-container">
        <a href="{{ route('products') }}" class="button"> @lang('buttons.logout')</a>
    </div>
@endsection

