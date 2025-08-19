@extends('layouts.app')
@section('title', 'roles Add')
@section('content')

<section class="section">
    <div class="row">
        <div class="col-lg-12">

            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        @can('role-list')
                        <a href="{{route('roles.index')}}" class="btn btn-info btn-sm"><i class="bi bi-list-task"></i>
                            @lang('common.list')</a>
                        @endcan
                        @can('role-create')
                        <a href="{{route('roles.create')}}" class="btn btn-info btn-sm"><i
                                class="bi bi-plus-circle"></i>
                            @lang('common.create')</a>
                        @endcan
                    </div>

                </div>
                <div class="bg-light p-4 rounded">
                    <h1>Add new role</h1>


                    <div class="container mt-4">

                        @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            <strong>Whoops!</strong> There were some problems with your input.<br><br>
                            <ul>
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif

                        <form method="POST" action="{{ route('roles.store') }}">
                            @csrf
                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input value="{{ old('name') }}" type="text" class="form-control" name="name"
                                    placeholder="Name" required>
                            </div>

                            <label for="permissions" class="form-label">Assign Permissions</label>

                            <table id="myTable" class=" display table datatable table-bordered  table-hover">
                                <thead>
                                    <th scope="col" width="1%"><input type="checkbox" name="all_permission"></th>
                                    <th scope="col" width="20%">Name</th>
                                    <th scope="col" width="1%">Guard</th>
                                </thead>
                                <tbody>
                                    @foreach($permissions as $permission)
                                    <tr>
                                        <td>
                                            <input type="checkbox" name="permission[{{ $permission->name }}]"
                                                value="{{ $permission->name }}" class='permission'>
                                        </td>
                                        <td>{{ $permission->name }}</td>
                                        <td>{{ $permission->guard_name }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>

                            </table>

                            <button type="submit" class="btn btn-primary">Save user</button>
                            <a href="{{ route('users.index') }}" class="btn btn-default">Back</a>
                        </form>
                    </div>

                </div>
            </div>

        </div>
    </div>
</section>

@endsection
@section('scripts')
<script type="text/javascript">
    $(document).ready(function() {
            $('[name="all_permission"]').on('click', function() {

                if($(this).is(':checked')) {
                    $.each($('.permission'), function() {
                        $(this).prop('checked',true);
                    });
                } else {
                    $.each($('.permission'), function() {
                        $(this).prop('checked',false);
                    });
                }

            });
        });
</script>
@endsection