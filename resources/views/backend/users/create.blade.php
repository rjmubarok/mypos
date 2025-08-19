@extends('layouts.app')
@section('title', 'users Add')
@section('content')

<section class="section">
    <div class="row">
        <div class="col-lg-12">

            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        @can('user-create')
                        <a href="{{route('users.create')}}" class="btn btn-info btn-sm"><i
                                class="bi bi-plus-circle"></i>
                            @lang('common.create')</a>
                        @endcan
                        @can('user-list')
                        <a href="{{route('users.index')}}" class="btn btn-info btn-sm"><i class="bi bi-list-task"></i>
                            @lang('common.list')</a>
                        @endcan

                    </div>

                </div>

            </div>
        </div>
        <div class="bg-light p-4 rounded">
            <div class="container mt-4">
                <form method="POST" action="{{route('users.store')}}">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input value="{{ old('name') }}" type="text" class="form-control" name="name" placeholder="Name"
                            required>

                        @if ($errors->has('name'))
                        <span class="text-danger text-left">{{ $errors->first('name') }}</span>
                        @endif
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input value="{{ old('email') }}" type="email" class="form-control" name="email"
                            placeholder="Email address" required>
                        @if ($errors->has('email'))
                        <span class="text-danger text-left">{{ $errors->first('email') }}</span>
                        @endif
                    </div>
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input value="{{ old('username') }}" type="text" class="form-control" name="username"
                            placeholder="Username" required>
                        @if ($errors->has('username'))
                        <span class="text-danger text-left">{{ $errors->first('username') }}</span>
                        @endif
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">password</label>
                        <input value="{{ old('password') }}" type="password" class="form-control" name="password"
                            placeholder="password" required>
                        @if ($errors->has('password'))
                        <span class="text-danger text-left">{{ $errors->first('password') }}</span>
                        @endif
                    </div>
                    <div class="mb-3">
                        <label for="roles" class="form-label">Select Roles</label>

                        <select name="roles" id="roles" class="form-control">
                            <option value="" selected>Select Roles</option>
                            @foreach ($roles as $role)
                            <option value="{{$role->name}}">{{$role->name}}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('roles'))
                        <span class="text-danger text-left">{{ $errors->first('roles') }}</span>
                        @endif
                    </div>
                    <div class="mb-3">
                        <label for="roles" class="form-label">Select Status</label>

                        <select name="status" id="status" class="form-control">
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                        @if ($errors->has('status'))
                        <span class="text-danger text-left">{{ $errors->first('status') }}</span>
                        @endif
                    </div>

                    <button type="submit" class="btn btn-primary">Save user</button>
                    <a href="{{ route('users.index') }}" class="btn btn-default">Back</a>
                </form>
            </div>

        </div>
    </div>
    </div>
</section>

@endsection
