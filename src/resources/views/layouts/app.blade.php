<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>COACHTECH</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/common.css') }}" />
    @yield('css')
</head>

<body>
    <header class="header">
        <div class="header__inner">
            <a class="header__logo" href="/">
                coachtech
            </a>
            @if ($headerType === 'default')
                @include('partials.headers.default')
            @elseif ($headerType === 'signin')
                @include('partials.headers.signin')
            @elseif ($headerType === 'signout')
                @include('partials.headers.signout')
            {{-- 動的にヘッダーを表示 --}}
            @elseif ($headerType === 'logged_in')
                @include('partials.headers.signin')
            @else
                @include('partials.headers.signout')
            @endif
        </div>
    </header>

    <main>
        @yield('content')
    </main>
</body>

</html>