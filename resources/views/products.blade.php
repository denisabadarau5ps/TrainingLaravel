@extends('layout')

@section('content')
    <h1>@lang('general.products')</h1>
    @foreach($products as $product)
        <div class="product-container">
            @include('product')
            <a href="{{ route('showEditForm') }}" class="button-products">@lang('buttons.edit')</a>
            <br>
            <form method="post" action="{{ route('delete') }}">
                @csrf
                <input type="hidden" id="id" name="id" value="{{ $product->id }}">
                <input type="submit" name="delete" value="@lang('buttons.delete')">
            </form>
        </div>
    @endforeach
    <div class="button-container">
        <a href="{{ route('showStoreForm') }}" class="button"> @lang('buttons.add')</a>
    </div>
    <br>
    <div class="button-container">
        <a href="{{ route('logout') }}" class="button"> @lang('buttons.logout')</a>
    </div>
@endsection

