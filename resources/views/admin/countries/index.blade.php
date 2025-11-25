@extends('admin.layout.main')

@section('title', 'list countries')

@section('content')
    <div class="row">
        <div class="col">
            <a href="{{ route('countries.create') }}" class="btn btn-outline-success">Add country</a>
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
                @foreach($countries as $country)
                    <tr>
                        <td>
                            {{$loop->iteration}}
                        </td>
                        <td>{{$country->name}}</td>
                        <td>
                            <a href="{{ route('countries.edit', $country->id) }}" class="btn btn-outline-warning">edit</a>
                            <form class="d-inline-block" action="{{route('countries.destroy', $country->id)}}" method="POST">
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
