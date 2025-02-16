@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/mypage.css') }}">
@endsection

@section('content')
<div class="container mypage-container">
    <!-- プロフィール情報 -->
    <div class="profile-header">
        <div class="profile-info">
            <img src="{{ asset('storage/' . Auth::user()->profile_image) }}" alt="プロフィール画像" class="profile-img">
            <h2>{{ Auth::user()->name }}</h2>
        </div>
        <a href="{{ url('/mypage/profile') }}" class="edit-profile">プロフィールを編集</a>
    </div>

    <!-- タブ切り替え -->
    <div class="tab-links">
        <a href="{{ url('/mypage?tab=sell') }}" class="{{ request('tab', 'sell') == 'sell' ? 'active' : '' }}">出品した商品</a>
        <a href="{{ url('/mypage?tab=buy') }}" class="{{ request('tab') == 'buy' ? 'active' : '' }}">購入した商品</a>
    </div>

    <!-- 商品リスト -->
    <div class="product-list">
        @foreach($products as $product)
        <div class="product-card">
            <img src="{{ asset('storage/' . $product->item_image) }}" alt="商品画像" class="product-img">
            <p class="product-title">{{ $product->title }}</p>
        </div>
        @endforeach
    </div>
</div>
@endsection
