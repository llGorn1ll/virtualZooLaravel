@extends('layouts.app')

@section('content')
@include('partials.header')
@if(session('success'))
    <p style="color:green">{{ session('success') }}</p>
@endif
@if($errors->any())
    <p style="color:red">{{ $errors->first() }}</p>
@endif
<form action="{{ url('addAnimal.php') }}" method="post">
    @csrf
    <label for="name">Название клетки </label><input type="text" name="name" id="name" required><br>
    <label for="cageCapacity">Вместимость клетки </label><input type="number" name="cageCapacity" id="cageCapacity" min="1" max="100" required><br>
    <button>Создать</button>
</form>
@endsection 