<form action="{{ route('movies.search') }}" method="GET">
    <input type="text" name="query" placeholder="Поиск фильмов...">
    <button type="submit">Искать</button>
</form>

@if(isset($movies))
    <ul>
        @foreach($movies as $movie)
            <li>{{ $movie->name }}</li>
        @endforeach
    </ul>
@else
    <p>Ничего не найдено.</p>
@endif
