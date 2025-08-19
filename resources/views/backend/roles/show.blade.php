@extends('layouts.app')
@section('title', 'Session Add')
@section('content')

<section class="section">
    <div class="row">
        <div class="col-lg-12">

            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        @can('role-create')
                        <a href="{{ route('roles.create') }}" class="btn btn-info btn-sm"><i
                                class="bi bi-plus-circle"></i>
                            @endcan

                            @lang('common.create')</a>
                        @can('role-list')
                        <a href="{{ route('roles.index') }}" class="btn btn-info btn-sm"><i class="bi bi-list-task"></i>
                            @lang('common.list')</a>
                        @endcan
                       

                    </div>

                </div>
                <h3>Assigned permissions</h3>
                <table id="myTable"  class=" display table datatable table-bordered  table-hover">
                    <thead>
                        <th scope="col" width="20%">Name</th>
                        <th scope="col" width="1%">Guard</th>
                    </thead>

                    @foreach ($rolePermissions as $permission)
                    <tr>
                        <td>{{ $permission->name }}</td>
                        <td>{{ $permission->guard_name }}</td>
                    </tr>
                    @endforeach
                </table>
            </div>

        </div>
        <div class="mt-4">
            <a href="{{ route('roles.edit', $role->id) }}" class="btn btn-info">Edit</a>
            <a href="{{ route('roles.index') }}" class="btn btn-default">Back</a>
        </div>
    </div>



</section>

@endsection
