@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/login.css') }}">
@endsection

@section('content')

    <h1>ログイン</h1>

    <form action="{{ route('login') }}" method="POST">
        @csrf
        <div>
            <label for="login">ユーザー名/メールアドレス:</label>
            <input type="email" name="email" id="email" value="{{ old('email') }}">
        </div>
        <div class="form__error">
            @error('email')
                <span>{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label for="password">パスワード:</label>
            <input type="password" name="password" id="password">
        </div>
        <div class="form__error">
            @error('password')
                <span>{{ $message }}</span>
            @enderror
        </div>

        <button type="submit">ログイン</button>
    </form>

    <a href="{{ route('register') }}">会員登録はこちら</a>
@endsection