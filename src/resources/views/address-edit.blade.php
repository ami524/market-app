@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/address-edit.css') }}">
@endsection

@section('content')
<div class="container">
    <h2 class="mb-4">住所の変更</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('purchase.address.update', ['item_id' => $item_id]) }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="post_code" class="form-label">郵便番号</label>
            <input type="text" class="form-control" id="post_code" name="post_code" value="{{ old('post_code', $user->post_code ?? '') }}" required>
        </div>
        <div class="form__error">
            @error('post_code')
                <span>{{ $message }}</span>
            @enderror
        </div>

        <div class="mb-3">
            <label for="address" class="form-label">住所</label>
            <input type="text" class="form-control" id="address" name="address" value="{{ old('address', $user->address ?? '') }}" required>
        </div>
        <div class="form__error">
            @error('address')
                <span>{{ $message }}</span>
            @enderror
        </div>

        <div class="mb-3">
            <label for="building" class="form-label">建物名</label>
            <input type="text" class="form-control" id="building" name="building" value="{{ old('building', $user->building ?? '') }}">
        </div>
        <div class="form__error">
            @error('building')
                <span>{{ $message }}</span>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">更新する</button>
    </form>
</div>
@endsection