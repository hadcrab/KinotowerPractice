@extends('admin.layout.main')

@section('content')
<div class="container">

    <h2>Фильмы</h2>

    <form method="GET">
        <select name="country_id">
            <option value="">Страна</option>
            @foreach($countries as $c)
                <option value="{{ $c->id }}">{{ $c->name }}</option>
            @endforeach
        </select>

        <select name="category_id">
            <option value="">Жанр</option>
            @foreach($categories as $cat)
                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
            @endforeach
        </select>

        <button type="submit">Фильтр</button>
    </form>

    <a href="{{ route('films.create') }}">Добавить фильм</a>

    <table>
        <thead>
            <tr>
                <th>Название</th>
                <th>Страна</th>
                <th>Год</th>
                <th>Возраст</th>
                <th>Длительность</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach($films as $film)
            <tr>
                <td>{{ $film->name }}</td>
                <td>{{ $film->country->name }}</td>
                <td>{{ $film->year_of_issue }}</td>
                <td>{{ $film->age }}</td>
                <td>{{ $film->duration }} мин</td>
                <td>
                    <a href="{{ route('films.edit', $film->id) }}">Изменить</a>
                    <form method="POST" action="{{ route('films.destroy', $film->id) }}">
                        @csrf
                        @method('DELETE')
                        <button>Удалить</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{ $films->links() }}

</div>
@endsection
