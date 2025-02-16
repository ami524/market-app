@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/register.css') }}">
@endsection

@section('content')

    <h1>会員登録</h1>

    <!-- 会員登録フォーム -->
    <form action="{{ route('register') }}" method="POST">
        @csrf

        <div>
            <label for="name">ユーザー名</label>
            <input type="text" name="name" id="name" value="{{ old('name') }}">
        </div>
        <div class="form__error">
            @error('name')
                <span>{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label for="email">メールアドレス</label>
            <input type="email" name="email" id="email" value="{{ old('email') }}">
        </div>
        <div class="form__error">
            @error('email')
                <span>{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label for="password">パスワード</label>
            <input type="password" name="password" id="password">
        </div>
        <div class="form__error">
            @error('password')
                <span>{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label for="password_confirmation">確認用パスワード</label>
            <input type="password" name="password_confirmation" id="password_confirmation">
        </div>

        <button type="submit">登録する</button>
    </form>
    <a href="{{ route('login') }}">ログインはこちら</a>

@endsection