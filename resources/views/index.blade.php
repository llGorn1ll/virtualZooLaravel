@extends('layouts.app')

@section('content')
@include('partials.header')
<div class="uppElements">
<h1>Виртуальный зоопарк</h1>
<p class="animal_count">В зоопарке на данный момент проживают <b>{{ $animal_count }}</b> животных.</p>
</div>
<div class="cages">
@foreach($cages as $cage)
    <a href="{{ url('cage.php?id=' . $cage->id) }}">
        <div class="cageElement">
            <b>Клетка:</b> {{ $cage->name }}<br>
            @if(session('user.id'))(<b>Вместимость:</b> {{ $cage->capacity }}) животных @endif
          
        </div>
    </a>
@endforeach
</div>
@endsection 