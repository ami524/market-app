@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')

    <div class="container">
        <!-- おすすめ商品（全商品表示） -->
        <div class="section-title">おすすめ</div>
        <div class="product-list">
            @foreach ($recommendedProducts ?? [] as $product)
                <div class="product-item">
                    <a href="{{ route('item.show', ['id' => $product->id]) }}">
                        <img src="{{ Storage::url($product->item_image) }}" alt="{{ $product->title }}">
                    </a>
                    <p>
                        <a href="{{ route('item.show', ['id' => $product->id]) }}">
                            {{ $product->title }}
                        </a>
                    </p>
                    <!-- 販売済みの商品には "Sold" を表示 -->
                    @if($product->is_sold)
                        <span class="sold-label">Sold</span>
                    @endif
                </div>
            @endforeach
        </div>

        <!-- マイリスト（いいねした商品） -->
        @if(Auth::check())
            <div class="section-title">マイリスト</div>
            <div class="product-list">
                @foreach ($likedProducts as $product)
                    <div class="product-item">
                        <a href="{{ route('item.show', ['id' => $product->id]) }}">
                            <img src="{{ asset('storage/' . $product->item_image) }}" alt="{{ $product->title }}">
                        </a>
                        <p>
                            <a href="{{ route('item.show', ['id' => $product->id]) }}">
                                {{ $product->title }}
                            </a>
                        </p>
                        <!-- 販売済みの商品には "Sold" を表示 -->
                        @if($product->is_sold)
                            <span class="sold-label">Sold</span>
                        @endif
                    </div>
                @endforeach
            </div>
        @else
            <p>ログインすると、マイリストを見ることができます。</p>
        @endif
    </div>

@endsection
