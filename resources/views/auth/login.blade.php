@extends('auth.layout.app')
@section('title','Login')
@section('content')
    @if(session('error'))
        <div class="text-end mt-2 alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
<div class="login form">
    <header>ورود</header>
    <form action="{{ route('login') }}" method="POST">
        @csrf
        <input type="text" name="email" class="text-end" placeholder="ایمیلتو بزن">
        @error('email')
        <div class="alert alert-danger text-danger p-1 text-end">{{ $message }}</div>
        @enderror
        <input type="password" name="password" class="text-end" placeholder="رمزتو بزن">
        @error('password')
        <div class="alert alert-danger text-danger p-1 text-end">{{ $message }}</div>
        @enderror
        <input type="submit" class="button" value="بزن بریم">
    </form>
    <div class="signup">
        <span class="signup">اگه اکانت نداری بزن رو لینک
         <a href="{{ route('show.register') }}">لینکی که باید بزنی روش</a>
        </span>
    </div>
</div>
@endsection
