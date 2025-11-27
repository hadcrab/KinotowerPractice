@extends('admin.layout.main')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between">
        <h3 class="card-title">Users</h3>

        <a href="{{ route('users.index', ['deleted' => $showDeleted ? 0 : 1]) }}" class="btn btn-secondary">
            {{ $showDeleted ? 'Show Active' : 'Show Deleted' }}
        </a>
    </div>

    <div class="card-body p-0">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Email</th>
                    <th>Name</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->name }}</td>
                        <td>
                            @if (!$showDeleted)
                                <form action="{{ route('users.destroy', $user->id) }}" method="POST">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-danger btn-sm">Delete</button>
                                </form>
                            @else
                                <form action="{{ route('users.restore', $user->id) }}" method="POST">
                                    @csrf
                                    <button class="btn btn-success btn-sm">Restore</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{ $users->links() }}
    </div>
</div>
@endsection
