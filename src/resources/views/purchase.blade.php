@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/purchase.css') }}">
@endsection

@section('content')
@php
    $selectedPayment = old('payment_method', 'convenience_store');
@endphp

<div class="container">
    <div class="row">
        <div class="col-md-7">
            <div class="card">
                <img src="{{ asset('storage/' . $product->item_image) }}" class="card-img-top" alt="商品画像">
                <div class="card-body">
                    <h5 class="card-title">{{ $product->title }}</h5>
                    <p class="card-text">￥ {{ number_format($product->price) }} </p>
                </div>
            </div>
        </div>

    <div class="row mt-4">
        <div class="col-md-7">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('purchase.process', ['item_id' => $product->id]) }}" method="POST">
                        @csrf
                        <h4>支払い方法</h4>
                        <div class="form-group">
                            <label for="payment_method">選択してください：</label>
                            <select id="payment_method" name="payment_method" class="form-control" required>
                                <option value="convenience_store" {{ $selectedPayment == 'convenience_store' ? 'selected' : '' }}>コンビニ払い</option>
                                <option value="credit_card" {{ $selectedPayment == 'credit_card' ? 'selected' : '' }}>カード支払い</option>
                            </select>
                        </div>
                        <div class="form__error">
                            @error('payment_method')
                                <span>{{ $message }}</span>
                            @enderror
                        </div>
                        <p class="mt-3">選択された支払い方法:
                            <span id="selected-payment-form">
                                {{ $selectedPayment == 'credit_card' ? 'カード支払い' : 'コンビニ払い' }}
                            </span>
                        </p>

                        <h4 class="mt-4">配送先</h4>
                        <p>{{ $user->address ?? '住所が登録されていません' }}</p>
                        <a href="{{ route('purchase.address', ['item_id' => $product->id]) }}">配送先を変更する</a>
                        <div class="form__error">
                            @error('delivery_address')
                                <span>{{ $message }}</span>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-success btn-block mt-4">購入する</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const paymentMethodSelect = document.getElementById('payment_method');
        const selectedPayment = document.getElementById('selected-payment');
        const selectedPaymentForm = document.getElementById('selected-payment-form');

        function updatePaymentText() {
            const selectedText = paymentMethodSelect.options[paymentMethodSelect.selectedIndex].text;
            selectedPayment.innerText = selectedText;
            selectedPaymentForm.innerText = selectedText;
        }

        // 初期表示時に適用
        updatePaymentText();

        // 支払い方法変更時に適用
        paymentMethodSelect.addEventListener('change', updatePaymentText);
    });
</script>
@endsection
