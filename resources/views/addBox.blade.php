@extends('layouts.app')

@section('content')
@include('partials.header')
@if(session('success'))
    <p style="color:green">{{ session('success') }}</p>
@endif
@if($errors->any())
    <p style="color:red">{{ $errors->first() }}</p>
@endif
<form action="{{ url('addBox.php') }}" method="post" enctype="multipart/form-data">
    @csrf
    <label for="species">Вид животного</label><input type="text" name="species" id="species" required><br>
    <label for="name">Имя животного</label><input type="text" name="name" id="name" required><br>
    <label for="age">Возраст</label><input type="number" name="age" id="age" min="0" max="100" required><br>
    <label for="description">Описание</label><input type="text" name="description" id="description"><br>
    <label for="image">Изображение</label><input type="file" name="image" id="image" accept="image/*" required><br>
    <label for="cage_id">Клетка</label>
    <select name="cage_id" id="cage_id" required>
        @foreach($cages as $cage)
            @php $free = $cage->capacity - $cage->animals_count; @endphp
            @if($free > 0)
                <option value="{{ $cage->id }}">
                    {{ $cage->name }} (Свободно мест: {{ $free }})
                </option>
            @endif
        @endforeach
    </select><br>
    <button>Добавить животное</button>
</form>
@endsection 