@extends('admin.layout.main')

@section('content')
<div class="content-wrapper p-3">
<section class="content-header">
<div class="container-fluid">
<div class="row mb-2">
<div class="col-sm-6">
<h1>Films</h1>
</div>
<div class="col-sm-6 text-right">
<a href="{{ route('films.create') }}" class="btn btn-primary">Add film</a>
</div>
</div>
</div>
</section>


<section class="content">
<div class="card">
<div class="card-header">
<h3 class="card-title">List film</h3>
</div>
<div class="card-body table-responsive p-0">
<table class="table table-hover text-nowrap">
<thead>
<tr>
<th>ID</th>
<th>Name</th>
<th>Year</th>
<th>Country</th>
<th>Adulting</th>
<th>Actions</th>
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
<a href="{{ route('films.edit', $film->id) }}" class="btn btn-sm btn-warning">Edit</a>
<form action="{{ route('films.destroy', $film->id) }}" method="POST" style="display:inline-block;">
@csrf
@method('DELETE')
<button class="btn btn-sm btn-danger" onclick="return confirm('Delete?')">Delete</button>
</form>
</td>
<td>
<a href="{{ route('film.categories.index', $film->id) }}" class="btn btn-info btn-sm">
    Geners
</a>
</td>
</tr>
<tr>
    <td colspan="10">
        <details>
            <summary>Отзывы ({{ $film->reviews->count() }})</summary>

            @foreach($film->reviews as $review)
                <div class="border p-2 my-1">
                    <strong>{{ $review->user?->name ?? 'User '.$review->user_id }}</strong>
                    <p>{{ $review->message }}</p>

                    <div class="d-flex gap-2">
                        @if(!$review->is_approved)
                            <form action="{{ route('reviews.approve', $review->id) }}" method="POST">
                                @csrf
                                <button class="btn btn-success btn-sm">Одобрить</button>
                            </form>
                        @endif

                        <form action="{{ route('reviews.delete', $review->id) }}" method="POST">
                            @csrf
                            @method("DELETE")
                            <button class="btn btn-danger btn-sm">Удалить</button>
                        </form>
                    </div>
                </div>
            @endforeach
        </details>

        <details>
            <summary>Оценки ({{ $film->ratings->count() }})</summary>

            @foreach($film->ratings as $rating)
                <div class="border p-2 my-1">
                    <strong>{{ $rating->user?->name ?? 'User '.$rating->user_id }}</strong>
                    <p>Оценка: {{ $rating->rating }}</p>

                    <form action="{{ route('ratings.delete', $rating->id) }}" method="POST">
                        @csrf
                        @method("DELETE")
                        <button class="btn btn-danger btn-sm">Удалить</button>
                    </form>
                </div>
            @endforeach
        </details>
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
