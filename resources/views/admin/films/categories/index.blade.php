@extends('admin.layout.main')

@section('content')

<div class="container-fluid">

    <h3 class="mb-4">Genres of film: <strong>{{ $film->name }}</strong></h3>

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Add new genre</h3>
        </div>

        <div class="card-body">
            <form action="{{ route('film.categories.store', $film->id) }}" method="POST">
                @csrf

                <div class="row">
                    <div class="col-md-6">
                        <select name="category_id" class="form-control">
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3">
                        <button class="btn btn-success">Add</button>
                    </div>
                </div>

            </form>
        </div>
    </div>

    <div class="card mt-4">
        <div class="card-header">
            <h3 class="card-title">Existing genres</h3>
        </div>

        <div class="card-body">

            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>Name</th>
                    <th width="150px">Actions</th>
                </tr>
                </thead>

                <tbody>
                @foreach($filmCategories as $cat)
                    <tr>
                        <td>{{ $cat->name }}</td>
                        <td>
                            <form action="{{ route('film.categories.destroy', [$film->id, $cat->id]) }}"
                                  method="POST"
                                  onsubmit="return confirm('Delete genre?')">
                                @csrf
                                @method('DELETE')

                                <button class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>

            </table>

        </div>
    </div>

</div>

@endsection
