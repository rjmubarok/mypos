@extends('layouts.app')
@section('title', 'Update User')
@section('content')

<section class="section">
    <div class="row">
        <div class="col-lg-12">

            <div class="card m-3">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('users.create') }}" class="btn btn-info btn-sm">
                            <i class="bi bi-plus-circle"></i> Create
                        </a>

                        <a href="{{ route('users.index') }}" class="btn btn-info btn-sm">
                            <i class="bi bi-list-task"></i> List
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('user_update', $user->id) }}">
                        @csrf
                        @method('PATCH')

                        {{-- Name --}}
                        <div class="mb-3">
                            <label class="form-label">Name</label>
                            <input value="{{ old('name', $user->name) }}" type="text" class="form-control" name="name" placeholder="Enter Name" required>
                            @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        {{-- Email --}}
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input value="{{ old('email', $user->email) }}" type="email" class="form-control" name="email" placeholder="Enter Email" required>
                            @error('email') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        

                        {{-- Role --}}
                        <div class="mb-3">
                            <label class="form-label">Role</label>
                            <select class="form-control" name="role" required>
                                <option value="">-- Select Role --</option>
                                @foreach ($roles as $role)
                                    <option value="{{ $role->name }}" 
                                        {{ in_array($role->name, $userRole) ? 'selected' : '' }}>
                                        {{ ucfirst($role->name) }}
                                    </option>
                                @endforeach
                            </select>
                            @error('role') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="d-flex justify-content-start">
                            <button type="submit" class="btn btn-primary me-2">Update User</button>
                            <a href="{{ route('users.index') }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
                
            </div>
        </div>
    </div>
</section>

@endsection
