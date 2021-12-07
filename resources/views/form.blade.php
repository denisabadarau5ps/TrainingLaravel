<form method="POST" action="/checkout">
    @csrf
    <div class="checkout-details-container">
        <input type="text" name="name"  placeholder=@lang('customer.name') value="{{ old('name') }}">
        <br>
        @error('name')
            <p class="errors">{{ $message }}</p>
        @enderror
        <br>
        <textarea id="contacts" name="contacts" placeholder=@lang('customer.contacts')>{{ old('contacts') }}</textarea>
        <br>
        @error('contacts')
        <p class="errors">{{ $message }}</p>
        @enderror
        <br>
        <textarea id="comments" name="comments" rows="5" placeholder=@lang('customer.comments')>{{ old('comments') }}</textarea>
        <br>
        @error('comments')
        <p class="errors">{{ $message }}</p>
        @enderror
        <input type="submit" name="checkout" value=@lang('buttons.checkout')>
    </div>
</form>
