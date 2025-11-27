@extends('admin.layout.main')
@section('content')
<div class="content-wrapper p-3">
<h1>Добавить жанр для фильма: {{ $film->name }}</h1>


<div class="card card-primary mt-3">
<div class="card-header"><h3 class="card-title">Добавление</h3></div>


<form method="POST" action="{{ route('film.categories.store', $film->id) }}">
@csrf
<div class="card-body">
<div class="form-group">
<label>Жанр</label>
<select name="category_id" class="form-control" required>
@foreach($categories as $cat)
<option value="{{ $cat->id }}">{{ $cat->name }}</option>
@endforeach
</select>
</div>
</div>


<div class="card-footer">
<button type="submit" class="btn btn-primary">Добавить</button>
</div>
</form>
</div>
</div>
@endsection
