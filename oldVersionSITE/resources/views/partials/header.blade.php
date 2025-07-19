<header>
    <ul>
        <li><a href="{{ url('index.php') }}">Главная страница</a></li>
        @if(session('user.id'))
            <li><a href="{{ url('addAnimal.php') }}">Добавить клетку</a></li>
            <li><a href="{{ url('addBox.php') }}">Добавить животного</a></li>
            <li><a href="{{ url('vendor/logOut.php') }}">Выйти</a></li>
        @endif
    </ul>
</header> 