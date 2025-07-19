@extends('layouts.app')

@section('content')
<h1>Вход</h1>
@if ($errors->has('login'))
    <p style='color:red'>{{ $errors->first('login') }}</p>
@endif
<form action="{{ url('login.php') }}" method="post">
    @csrf
    <label for="login">Логин</label>
    <input type="text" name="login" id="login" required value="{{ old('login') }}">
    <button>Войти</button>
</form>
@endsection 