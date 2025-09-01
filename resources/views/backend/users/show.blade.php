@extends('layouts.app')
@section('title', 'Show User')
@section('content')

<section class="section">
    <div class="row justify-content-center">
        <div class="col-lg-8">

            <div class="card shadow-sm my-4">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h4 class="mb-0"><i class="bi bi-person-circle"></i> User Details</h4>
                    <div>
                        @can('user-edit')
                        <a href="{{ route('users.edit', $user->id) }}" class="btn btn-light btn-sm me-1">
                            <i class="bi bi-pencil-square"></i> Edit
                        </a>
                        @endcan
                        @can('user-list')
                        <a href="{{ route('users.index') }}" class="btn btn-light btn-sm">
                            <i class="bi bi-list-task"></i> List
                        </a>
                        @endcan
                    </div>
                </div>

                <div class="card-body bg-light">
                    <div class="text-center mb-4">
                        <i class="bi bi-person-circle" style="font-size: 80px; color: #0d6efd;"></i>
                    </div>

                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <strong>Name:</strong> <span class="badge bg-info text-dark">{{ $user->name }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <strong>Email:</strong> <span class="badge bg-success">{{ $user->email }}</span>
                        </li>

                        @if($user->roles)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <strong>Roles:</strong>
                            @foreach($user->roles as $role)
                                <span class="badge bg-primary me-1">{{ ucfirst($role->name) }}</span>
                            @endforeach
                        </li>
                        @endif
                    </ul>

                    <div class="mt-4 text-center">
                        <a href="{{ route('users.index') }}" class="btn btn-secondary btn-sm me-2">
                            <i class="bi bi-arrow-left-circle"></i> Back
                        </a>
                        @can('user-edit')
                        <a href="{{ route('users.edit', $user->id) }}" class="btn btn-primary btn-sm">
                            <i class="bi bi-pencil-square"></i> Edit User
                        </a>
                        @endcan
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

@endsection
