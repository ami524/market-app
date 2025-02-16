
<form action="{{ route('search') }}" method="POST" class="search-form">
    <input type="text" name="search" placeholder="なにをお探しですか？" value="{{ request('search') }}" onkeypress="if(event.key === 'Enter') this.form.submit();">
</form>
<div class="right-buttons">
    <button onclick="location.href='/login'">ログイン</button>
    <button onclick="location.href='/mypage'">マイページ</button>
    <button onclick="location.href='/sell'">出品</button>
</div>

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/signout.css') }}">
@endpush