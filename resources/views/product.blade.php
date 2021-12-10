<img class="product-image" src="{{ url('storage/images/'.$product->id . '.' . $product->extension) }}" alt=@lang('product.image')>
<h3>{{ $product->title }}</h3>
<div class="product-desc">
    {{ $product->description }}<br>
    {{ $product->price }}$
</div>
