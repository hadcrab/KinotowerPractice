@extends('admin.layout.main')

@section('title', 'list categories')

@section('content')
    <div class="row">
        <div class="col">
            <a href="{{ route('categories.create') }}" class="btn btn-outline-success">Add category</a>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <table class="table">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th class="w-40"></th>

                </tr>
                </thead>
                <tbody>
                @foreach($categories as $category)
                    <tr>
                        <td>
                            {{$loop->iteration}}
                        </td>
                        <td>{{$category->name}}</td>
                        <td>{{ isset($category->parentCategory) ? $category->parentCategory->name : 'No parent' }}</td>
                        <td>
                            <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-outline-warning">edit</a>
                            <form class="d-inline-block" action="{{route('categories.destroy', $category->id)}}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-outline-danger">delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
