@extends('layout')

@section ('content')
    <table>
        <tr>
            <th>Image</th>
            <th>Title</th>
            <th>Description</th>
            <th>Price</th>
            <th>Option</th>
        </tr>
        @foreach($products as $product)
            <tr>
                <td>
                    <img class="product-image" src="{{$product->getFirstMediaUrl('products', 'thumb')}}"/>
                </td>
                <td> {{ $product->translateAttribute('name') }} </td>
                <td> {{ $product->translateAttribute('description') }} </td>
                <td>
                    {{ $product->variants->pluck('prices')->flatten()->sortBy('price')->first()->price->formatted }}
                </td>
                <td>
                    <a href="{{ route('show.product.form', ['id' => $product->id]) }}" class="button-products">@lang('buttons.edit')</a>
                    <form method="post" action="{{ route('remove.product') }}">
                        @csrf
                        <input type="hidden" id="id" name="id" value="{{ $product->id }}">
                        <input type="submit" name="delete" value="@lang('buttons.delete')">
                    </form>
                </td>
            </tr>
        @endforeach
    </table>
    <div class="button-container">
        <a href="{{ route('show.product.form', ['id' => 0]) }}">
            <button class="btn"> @lang('buttons.add') </button>
        </a>
    </div>
@endsection
