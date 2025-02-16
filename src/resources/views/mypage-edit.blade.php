@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/mypage.css') }}">
@endsection

@section('content')
<div class="profile-container">
    <h2 class="profile-title">プロフィール設定</h2>

    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="profile-form">
        @csrf
        <div class="profile-image-section">
            <img src="{{ Auth::user()->profile_image ? asset('storage/' . Auth::user()->profile_image) : asset('images/default-profile.png') }}" class="profile-image" alt="プロフィール画像">
            <input type="file" name="profile_image" class="file-input">
        </div>
        <div class="form__error">
            @error('profile_image')
                <span>{{ $message }}</span>
            @enderror
        </div>

        <label for="name">ユーザー名</label>
        <input type="text" id="name" name="name" value="{{ Auth::user()->name }}" required>

        <label for="post_code">郵便番号</label>
        <input type="text" id="post_code" name="post_code" value="{{ Auth::user()->post_code }}">

        <label for="address">住所</label>
        <input type="text" id="address" name="address" value="{{ Auth::user()->address }}">

        <label for="building">建物名</label>
        <input type="text" id="building" name="building" value="{{ Auth::user()->building }}">

        <button type="submit" class="update-button">更新する</button>
    </form>
</div>

@endsection