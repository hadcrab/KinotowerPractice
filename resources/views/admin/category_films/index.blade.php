@extends('admin.layout.main')
@section('content')
<div class="content-wrapper p-3">
<section class="content-header">
<h1>Жанры фильма: {{ $film->name }}</h1>
<a href="{{ route('film.categories.create', $film->id) }}" class="btn btn-primary mt-2">Добавить жанр</a>
</section>


<section class="content mt-3">
<div class="card">
<div class="card-header"><h3 class="card-title">Список жанров</h3></div>
<div class="card-body p-0">
<table class="table table-hover text-nowrap">
<thead>
<tr>
<th>ID</th>
<th>Название</th>
<th>Действие</th>
</tr>
</thead>
<tbody>
@foreach($film->categories as $cat)
<tr>
<td>{{ $cat->id }}</td>
<td>{{ $cat->name }}</td>
<td>
<form method="POST" action="{{ route('film.categories.destroy', [$film->id, $cat->id]) }}">
@csrf
@method('DELETE')
<button class="btn btn-danger btn-sm">Удалить</button>
</form>
</td>
</tr>
@endforeach
</tbody>
</table>
</div>
</div>
</section>
</div>
@endsection
