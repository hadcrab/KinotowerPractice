@extends('admin.layout.main')

@section('title', isset($country) ? 'Edit country: '.$country->name : 'Add country')

@section('content')
    <div class="row">
        <div class="col">
            <form action="{{ isset($country) ? route('countries.update', $country->id) : route('countries.store') }}" method="POST">
                @csrf
                @isset($country)
                    @method('PATCH')
                @endisset
                <label class="form-label" for="name">Name</label>
                <input class="form-control" name="name" id="name" type="text" value="{{ isset($country) ? old('name', $country->name) : old('name') }}">

            <div class="mt-4">
                <button class="btn btn-outline-success" type="submit">save</button>
            </div>
            </form>
        </div>
    </div>
@endsection
