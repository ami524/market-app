@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/detail.css') }}">
@endsection

@section('content')
<div class="container">
    <div class="product-detail">
        <!-- 左側：商品画像 -->
        <div class="product-image">
            <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}">
        </div>

        <!-- 右側：商品情報 -->
        <div class="product-info">
            <h1>{{ $product->name }}</h1>
            <p class="brand">ブランド: {{ $product->brand ?? 'なし' }}</p>
            <p class="price">価格: ¥{{ number_format($product->price) }}（税込）</p>

            <!-- いいね数・コメント数 -->
            <div class="product-stats">
                <span class="like-icon" data-product-id="{{ $product->id }}">
                    <i class="fa{{ $liked ? 's' : 'r' }} fa-heart"></i>
                    <span id="like-count">{{ $product->likes_count }}</span>
                </span>
                <span class="comments-count">
                    <i class="far fa-comment"></i> {{ $product->comments_count }}
                </span>
            </div>

            <!-- 購入手続きボタン -->
            @auth
            <div class="purchase-button">
                <a href="{{ route('purchase.show', ['item_id' => $product->id]) }}" class="btn btn-primary">
                    購入手続きへ
                </a>
            </div>
            @endauth

            <!-- 商品説明 -->
            <p class="description">{{ $product->description }}</p>

            <!-- 商品情報 -->
            <div class="product-meta">
                <p>カテゴリー: {{ $product->category->name }}</p>
                <p>商品の状態: {{ $product->condition }}</p>
            </div>

            <!-- コメント欄 -->
            <div class="comments">
                <h3>コメント</h3>
                @foreach($product->comments as $comment)
                    <div class="comment">
                        <p><strong>{{ $comment->user->name }}</strong>: {{ $comment->content }}</p>
                    </div>
                @endforeach
            </div>

            <!-- コメント入力欄 -->
            @auth
            <form action="{{ route('comment.store', $product->id) }}" method="POST">
                @csrf
                <textarea name="content" rows="3" placeholder="コメントを入力してください"></textarea>
                <button type="submit">コメントを送信する</button>
            </form>
            @endauth
        </div>
    </div>
</div>

<!-- いいね機能のJavaScript -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    const likeIcon = document.querySelector('.like-icon');
    likeIcon.addEventListener('click', function () {
        const productId = this.dataset.productId;
        const likeCount = document.getElementById('like-count');
        const icon = this.querySelector('i');

        fetch(`/like/${productId}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            },
        })
        .then(response => response.json())
        .then(data => {
            likeCount.textContent = data.likes_count;
            icon.classList.toggle('fas');
            icon.classList.toggle('far');
        })
        .catch(error => console.error('エラー:', error));
    });
});
</script>
@endsection