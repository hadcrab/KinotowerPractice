@extends('admin.layout.main')

@section('title', isset($category) ? 'Edit genre: '.$category->name : 'Add new genre')

@section('content')
    <div class="row">
        <div class="col">
            <form action="{{ isset($category) ? route('categories.update', $category->id) : route('categories.store') }}" method="POST">
                @csrf
                @isset($category)
                    @method('PATCH')
                @endisset
                <label class="form-label" for="name">Name</label>
                <input class="form-control" name="name" id="name" type="text" value="{{ isset($category) ? old('name', $category->name) : old('name') }}">
                <div class="mt-4">
                    <label class="form-label" for="parent_id">Parent genre</label>
                    <select name="parent_id" id="parent_id" class="form-select">
                        <option value="">No parent genre</option>
                        @foreach($categories as $itemCategory)
                            <option @selected(isset($category)
                                    && $category->itemCategory
                                    && $category->itemCategory->id === $itemCategory->id)
                                    value="{{ $itemCategory->id }}">
                                {{ $itemCategory->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="mt-4">
                    <button class="btn btn-outline-success" type="submit">save</button>
                </div>
            </form>
        </div>
    </div>
@endsection
