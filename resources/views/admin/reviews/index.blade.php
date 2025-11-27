@extends('admin.layout.main')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Reviews</h3>
    </div>

    <div class="card-body">
        <form class="mb-3">
            <label>Select film: </label>
            <select name="film_id" onchange="this.form.submit()" class="form-control w-25 d-inline-block">
                <option value="">All Reviews</option>
                @foreach ($films as $film)
                    <option value="{{ $film->id }}" @selected($filmId == $film->id)>
                        {{ $film->name }}
                    </option>
                @endforeach
            </select>
        </form>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Film</th>
                    <th>User</th>
                    <th>Text</th>
                    <th>Approved</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($reviews as $r)
                    <tr>
                        <td>{{ $r->id }}</td>
                        <td>{{ $r->film->name }}</td>
                        <td>{{ $r->user->email }}</td>
                        <td>{{ $r->text }}</td>
                        <td>{{ $r->approved ? 'Yes' : 'No' }}</td>
                        <td class="d-flex gap-1">
                            @if (!$r->approved)
                                <form method="POST" action="{{ route('reviews.approve', $r->id) }}">
                                    @csrf
                                    <button class="btn btn-success btn-sm">Approve</button>
                                </form>
                            @endif

                            <form method="POST" action="{{ route('reviews.destroy', $r->id) }}">
                                @csrf @method('DELETE')
                                <button class="btn btn-danger btn-sm">Del</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{ $reviews->links() }}
    </div>
</div>
@endsection
