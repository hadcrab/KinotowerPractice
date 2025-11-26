@extends('admin.layout.main')

@section('content')
<h2>Добавить фильм</h2>

<form method="POST" action="{{ route('films.store') }}">
    @csrf

    <input name="name" placeholder="Название">

    <select name="country_id">
        @foreach($countries as $c)
            <option value="{{ $c->id }}">{{ $c->name }}</option>
        @endforeach
    </select>

    <input name="duration" placeholder="Длительность (мин)">

    <input name="year_of_issue" placeholder="Год выпуска">

    <input name="age" placeholder="Возрастной рейтинг">

    <input name="link_img" placeholder="Ссылка на изображение">

    <input name="link_kinopoisk" placeholder="Ссылка на Кинопоиск">

    <input name="link_video" placeholder="Ссылка на видео">

    <h4>Жанры:</h4>
    @foreach($categories as $cat)
        <label>
            <input type="checkbox" name="categories[]" value="{{ $cat->id }}">
            {{ $cat->name }}
        </label>
    @endforeach

    <button>Сохранить</button>
</form>
@endsection
