@extends('layouts.app')

@section('content')
@include('partials.header')
<a href="{{ url('index.php') }}" style="display:inline-block; margin-bottom:15px;">&larr; Назад к списку клеток</a>
<h2>Клетка: {{ $cage->name }} @if(session('user.id'))(Вместимость: {{ $cage->capacity }})@endif</h2>
@if(session('cage_delete_error'))
    <p style="color:red">{{ session('cage_delete_error') }}</p>
@endif
@if(session('cage_edit_success'))
    <p style="color:green">{{ session('cage_edit_success') }}</p>
@endif
@if($errors->has('new_capacity'))
    <p style="color:red">{{ $errors->first('new_capacity') }}</p>
@endif
@if(session('user.id'))
<form method="post" action="{{ url('cage.php?id=' . $cage->id) }}" style="margin-bottom:20px;">
    @csrf
    <label>Названttие: <input type="text" name="new_name" value="{{ $cage->name }}" required></label><br>
    <label>Вместимость: <input type="number" name="new_capacity" value="{{ $cage->capacity }}" min="1" required></label><br>
    <button type="submit" name="edit_cage">Изменить параметры</button>
</form>
<form method="post" action="{{ url('cage.php/delete?id=' . $cage->id) }}" style="margin-bottom:20px;">
    @csrf
    <button type="submit" name="delete_cage" onclick="return confirm('Удалить клетку?')">Удалить клетку</button>
</form>
@endif
@if($animals->count() == 0)
    <p class="noAnimals">В этой клетке пока нет животных.</p>
@else
    <ul>
    @foreach($animals as $animal)
        <a href="{{ url('animal.php?id=' . $animal->id) }}" style="text-decoration:none;color:inherit;">
            <li style="cursor:pointer; width:280px; display:inline-block; vertical-align:top; margin:10px;">
                @if($animal->image)
                    <img src="{{ asset($animal->image) }}" alt="img" style="width:280px; height:280px; object-fit:cover; display:block; margin-bottom:5px;">
                @endif
                <div style="width:180px; word-break:break-word; white-space:normal;">
                    <b>{{ $animal->species }}</b> — {{ $animal->name }}, возраст: {{ $animal->age }}<br>
                    <i>{{ $animal->description }}</i><br>
                </div>
            </li>
        </a>
    @endforeach
    </ul>
@endif
@endsection 