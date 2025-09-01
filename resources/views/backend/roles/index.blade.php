@extends('layouts.app')
@section('title', 'Roles')
@section('content')
<section class="section">
    <div class="row">
        <div class="col-lg-12">

            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <a href="{{ route('roles.create') }}" class="btn btn-info btn-sm"><i class="bi bi-plus-circle"></i> Create</a>
                    <a href="{{ route('roles.index') }}" class="btn btn-secondary btn-sm"><i class="bi bi-list-task"></i> Roles</a>
                </div>

                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <table id="myTable" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>Permissions</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($roles as $role)
                            <tr id="row-{{ $role->id }}">
                                <td>{{ $role->id }}</td>
                                <td>{{ $role->name }}</td>
                                <td>
                                    @foreach($role->permissions as $perm)
                                        <span class="badge bg-success">{{ $perm->name }}</span>
                                    @endforeach
                                </td>
                                <td class="d-flex">
                                    <a class="btn btn-info btn-sm m-1" href="{{ route('roles.show', $role->id) }}"><i class="bi bi-eye-fill"></i></a>
                                    <a class="btn btn-primary btn-sm m-1" href="{{ route('roles.edit', $role->id) }}"><i class="bi bi-pencil-square"></i></a>
                                    <form action="{{ route('roles.destroy', $role->id) }}" method="POST" class="m-1 delete-form">
                                        @method('DELETE')
                                        @csrf
                                        <button type="submit" class="btn btn-danger btn-sm "><i class="bi bi-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</section>
@endsection


