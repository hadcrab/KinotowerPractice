@extends('admin.layout.main')

@section('content')
<div class="content-wrapper p-3">
<section class="content-header">
<div class="container-fluid">
<div class="row mb-2">
<div class="col-sm-6">
<h1>Фильмы</h1>
</div>
<div class="col-sm-6 text-right">
<a href="{{ route('films.create') }}" class="btn btn-primary">Добавить фильм</a>
</div>
</div>
</div>
</section>


<section class="content">
<div class="card">
<div class="card-header">
<h3 class="card-title">Список фильмов</h3>
</div>
<div class="card-body table-responsive p-0">
<table class="table table-hover text-nowrap">
<thead>
<tr>
<th>ID</th>
<th>Название</th>
<th>Год</th>
<th>Страна</th>
<th>Возраст</th>
<th>Действия</th>
</tr>
</thead>
<tbody>
@foreach($films as $film)
<tr>
<td>{{ $film->id }}</td>
<td>{{ $film->name }}</td>
<td>{{ $film->year_of_issue }}</td>
<td>{{ $film->country->name ?? '-' }}</td>
<td>{{ $film->age }}</td>
<td>
<a href="{{ route('films.edit', $film->id) }}" class="btn btn-sm btn-warning">Редактировать</a>
<form action="{{ route('films.destroy', $film->id) }}" method="POST" style="display:inline-block;">
@csrf
@method('DELETE')
<button class="btn btn-sm btn-danger" onclick="return confirm('Удалить фильм?')">Удалить</button>
</form>
</td>
<td>
<a href="{{ route('film.categories.index', $film->id) }}" class="btn btn-info btn-sm">
    Жанры
</a>
</td>
</tr>
@endforeach
</tbody>
</table>
</div>


<div class="card-footer clearfix">
{{ $films->links() }}
</div>
</div>
</section>
</div>
@endsection
