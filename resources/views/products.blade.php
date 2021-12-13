@extends('layout')

@section('content')
    <h1>@lang('general.products')</h1>
    @foreach($products as $product)
        <div class="product-container">
            @include('product')
            <br>
            <a href="{{ route('show.product.form', ['id' => $product->id]) }}" class="button-products">@lang('buttons.edit')</a>
            <br><br>
            <form method="post" action="{{ route('remove.product') }}">
                @csrf
                <input type="hidden" id="id" name="id" value="{{ $product->id }}">
                <input type="submit" name="delete" value="@lang('buttons.delete')">
            </form>
        </div>
    @endforeach
    <div class="button-container">
        <a href="{{ route('show.product.form', ['id' => null]) }}" class="button"> @lang('buttons.add')</a>
    </div>
    <br>
    <div class="button-container">
        <a href="{{ route('logout') }}" class="button"> @lang('buttons.logout')</a>
    </div>
@endsection

