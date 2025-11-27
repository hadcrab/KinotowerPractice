@extends('admin.layout.main')


@section('content')
<div class="content-wrapper p-3">
<section class="content-header">
<div class="container-fluid">
<h1>{{ isset($film) ? 'Редактировать фильм' : 'Добавить фильм' }}</h1>
</div>
</section>


<section class="content">
<div class="card card-primary">
<div class="card-header">
<h3 class="card-title">{{ isset($film) ? 'Редактирование' : 'Создание' }}</h3>
</div>


<form action="{{ isset($film) ? route('films.update', $film->id) : route('films.store') }}" method="POST">
@csrf
@if(isset($film)) @method('PUT') @endif


<div class="card-body">
<div class="form-group">
<label>Название</label>
<input type="text" name="name" class="form-control" value="{{ $film->name ?? '' }}" required>
</div>
<div class="form-group">
<label>Страна</label>
<select name="country_id" class="form-control" required>
<option disabled selected>Выберите страну</option>
@foreach($countries as $country)
<option value="{{ $country->id }}" @if(isset($film) && $film->country_id == $country->id) selected @endif>
{{ $country->name }}
</option>
@endforeach
</select>
</div>
<div class="form-group">
<label>Длительность (мин)</label>
<input type="number" name="duration" class="form-control" value="{{ $film->duration ?? '' }}" required>
</div>
<div class="form-group">
<label>Год выпуска</label>
<input type="number" name="year_of_issue" class="form-control" value="{{ $film->year_of_issue ?? '' }}" required>
</div>
<div class="form-group">
<label>Возрастной рейтинг</label>
<input type="text" name="age" class="form-control" value="{{ $film->age ?? '' }}" required>
</div>
<div class="form-group">
<label>Постер (URL)</label>
<input type="text" name="link_img" class="form-control" value="{{ $film->link_img ?? '' }}">
</div>
<div class="form-group">
<label>Кинопоиск (URL)</label>
<input type="text" name="link_kinopoisk" class="form-control" value="{{ $film->link_kinopoisk ?? '' }}">
</div>
<div class="form-group">
<label>Видео (URL)</label>
<input type="text" name="link_video" class="form-control" value="{{ $film->link_video ?? '' }}">
</div>
</div>


<div class="card-footer">
<button type="submit" class="btn btn-primary">Сохранить</button>
</div>
</form>
</div>
</section>
</div>
@endsection
