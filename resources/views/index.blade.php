@extends('layout')

@section ('content')
    <table>
        <tr>
            <th>Product</th>
            <th>Title</th>
            <th>Description</th>
            <th>Price</th>
            <th>Options</th>
        </tr>
    @foreach($products as $product)
        <tr>
            <td>
                <img class="product-image" src="{{ url('storage/images/'.$product->id . '.' . $product->extension) }}" alt=@lang('product.image')>
            </td>
            <td> {{ $product->title }} </td>
            <td> {{ $product->description }} </td>
            <td> {{ $product->price }}$ </td>
            <td>
                <form method="post" action="{{ route('add.to.cart') }}">
                    @csrf
                    <input type="hidden" id="id" name="id" value="{{ $product->id }}">
                    <button type="submit" value="add">@lang('buttons.add')</button>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
    <div class="button-container">
        <a href="{{ route('show.cart') }}">
            <button class="btn"> @lang('buttons.cart')</button>
        </a>
    </div>
@endsection
