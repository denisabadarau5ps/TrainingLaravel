@extends('layout')

@section('content')
    <div class="login-container">
        <h1>@lang('login.login')</h1>
        @if (session('status'))
            <div class="error-message">
                <p>{{ session('status') }}</p>
            </div>
        @endif
        <form method="post" action="{{ route('login') }}">
            @csrf
            <label for="username">@lang('login.username')</label>
            <input type="text" id="username" name="username" value="{{ old('username') }}">
            <br>
            @error('username')
                <p class="errors">{{ $message }}</p>
            @enderror
            <br>
            <label for="password">@lang('login.password')</label>
            <input type="password" name="password">
            <br>
            @error('password')
            <p class="errors">{{ $message }}</p>
            @enderror
            <br>
            <input type="submit" name="login" value=@lang('buttons.login')>
        </form>
    </div>
@endsection
