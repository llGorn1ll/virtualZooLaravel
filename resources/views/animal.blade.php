@extends('layouts.app')

@section('content')
@include('partials.header')
@if(!$animal)
    <p>Животное не найдено.</p>
@else
<div class="animal-card fade-in animal-card-max">
    <h2 class="animal-title">
        {{ $animal->name }}
    </h2>
    @if($animal->image)
        <img src="{{ asset($animal->image) }}" alt="img" class="animal-photo animal-img-center">
    @endif
    <div class="animal-info-center">
        <b>Вид:</b> {{ $animal->species }}<br>
        <b>Возраст:</b> {{ $animal->age }}<br>
        <b>Описание:</b> {{ $animal->description }}<br>
    </div>
    @if(session('user.id'))
        @if(session('edit_success'))
            <p class="success">{{ session('edit_success') }}</p>
        @endif
        @if($errors->any())
            <p class="animal-error">{{ $errors->first() }}</p>
        @endif
        <form method="post" enctype="multipart/form-data" action="{{ url('animal.php?id=' . $animal->id) }}" class="animal-form-margin">
            @csrf
            <label>Вид: <input type="text" name="species" value="{{ $animal->species }}" required></label><br>
            <label>Имя: <input type="text" name="name" value="{{ $animal->name }}" required></label><br>
            <label>Возраст: <input type="number" name="age" value="{{ $animal->age }}" min="0" max="100" required></label><br>
            <label>Описание: <input type="text" name="description" value="{{ $animal->description }}"></label><br>
            <label>Новое изображение: <input type="file" name="image" accept="image/*"></label><br>
            <button type="submit" name="edit_animal">Сохранить изменения</button>
        </form>
        <form method="post" action="{{ url('animal.php/delete?id=' . $animal->id) }}" class="animal-form-margin">
            @csrf
            <button type="submit" onclick="return confirm('Удалить животное?')">Удалить животное</button>
        </form>
    @endif
    <div class="animal-link-bottom">
        <a href="{{ url('cage.php?id=' . $animal->cage_id) }}">Вернуться к клетке</a>
    </div>
</div>
@endif
@endsection 