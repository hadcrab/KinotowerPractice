@extends('admin.layout.main')

@section('content')
<h2>Редактировать фильм</h2>

<form method="POST" action="{{ route('films.update', $film->id) }}">
    @csrf
    @method('PUT')

    <input name="name" value="{{ $film->name }}">

    <select name="country_id">
        @foreach($countries as $c)
            <option value="{{ $c->id }}" @selected($film->country_id == $c->id)>
                {{ $c->name }}
            </option>
        @endforeach
    </select>

    <input name="duration" value="{{ $film->duration }}">

    <input name="year_of_issue" value="{{ $film->year_of_issue }}">

    <input name="age" value="{{ $film->age }}">

    <input name="link_img" value="{{ $film->link_img }}">

    <input name="link_kinopoisk" value="{{ $film->link_kinopoisk }}">

    <input name="link_video" value="{{ $film->link_video }}">

    <h4>Жанры:</h4>
    @foreach($categories as $cat)
        <label>
            <input type="checkbox"
                   name="categories[]"
                   value="{{ $cat->id }}"
                   @checked(in_array($cat->id, $selected_categories))
            >
            {{ $cat->name }}
        </label>
    @endforeach

    <button>Сохранить</button>
</form>
@endsection
