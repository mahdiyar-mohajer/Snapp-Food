@extends('auth.layout.app')
@section('title','Register')
@section('content')
    @if(session('error'))
        <div class="text-end mt-2 alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
<div class="form">
    <header>ثبت نام</header>
    <form action="{{ route('register') }}" method="POST">
        @csrf
        <input type="text" name="name" class="text-end" placeholder="اسمت چیه؟">
        @error('name')
        <div class="alert alert-danger text-danger p-1 text-end">{{ $message }}</div>
        @enderror
        <input type="text" name="email" class="text-end" placeholder="ایمیلتو بزن">
        @error('email')
        <div class="alert alert-danger text-danger p-1 text-end">{{ $message }}</div>
        @enderror
        <input type="password" name="password" class="text-end" placeholder="رمزتو بزن">
        @error('password')
        <div class="alert alert-danger text-danger p-1 text-end">{{ $message }}</div>
        @enderror
        <input type="password" name="password_confirmation" class="text-end" placeholder="اگه راست میگی یه بار دیگه رمزتو بزن">
        @error('password')
        <div class="alert alert-danger text-danger p-1 text-end">{{ $message }}</div>
        @enderror
        <input type="submit" class="button" value="بثبتش">
    </form>
    <div class="signup">
        <span class="signup">اگه اکانت داری اینجا چیکار میکنی!
         <a href="{{ route('show.login') }}">برو اینجا</a>
        </span>
    </div>
</div>
@endsection
