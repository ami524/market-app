@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/listing.css') }}">
@endsection

@section('content')

<div class="container">
    <h1>商品の出品</h1>

    <form action="{{ route('sell.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- 商品画像 -->
        <div class="form-group">
            <label for="image">商品画像</label>
            <input type="file" name="image" id="image" class="form-control">
        </div>
        <div class="form__error">
            @error('image')
                <span>{{ $message }}</span>
            @enderror
        </div>

        <!-- 商品の詳細 -->
        <div class="form-group">
            <label>カテゴリー</label><br>
            @foreach($categories as $category)
                <label>
                    <input type="checkbox" name="categories[]" value="{{ $category }}"> {{ $category }}
                </label>
            @endforeach
        </div>
        <div class="form__error">
            @error('categories')
                <span>{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="condition">商品の状態</label>
            <select name="condition" id="condition" class="form-control">
                <option value="">選択してください</option>
                @foreach($conditions as $condition)
                    <option value="{{ $condition }}">{{ $condition }}</option>
                @endforeach
            </select>
        </div>
        <div class="form__error">
            @error('condition')
                <span>{{ $message }}</span>
            @enderror
        </div>

        <!-- 商品名と説明 -->
        <div class="form-group">
            <label for="name">商品名</label>
            <input type="text" name="name" id="name" class="form-control">
        </div>
        <div class="form__error">
            @error('name')
                <span>{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="brand">ブランド名</label>
            <input type="text" name="brand" id="brand" class="form-control">
        </div>

        <div class="form-group">
            <label for="description">商品の説明</label>
            <textarea name="description" id="description" class="form-control"></textarea>
        </div>
        <div class="form__error">
            @error('description')
                <span>{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="price">販売価格</label>
            <input type="number" name="price" id="price" class="form-control">
        </div>
        <div class="form__error">
            @error('price')
                <span>{{ $message }}</span>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">出品する</button>
    </form>
</div>

@endsection