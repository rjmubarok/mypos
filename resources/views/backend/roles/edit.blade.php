@extends('layouts.app')
@section('title', 'update permission')
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
                <div class="bg-light p-4 rounded">
                    <h1>Update role</h1>
                    <div class="lead">
                        Edit role and manage permissions.
                    </div>

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

                        <form method="POST" action="{{ route('roles.update', $role->id) }}">
                            @method('patch')
                            @csrf
                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input value="{{ $role->name }}" type="text" class="form-control" name="name"
                                    placeholder="Name" required>
                            </div>

                            <label for="permissions" class="form-label">Assign Permissions</label>


                            <div class="row">
                                <div class="col-sm-12 mt-2 mb-2 d-flex justify-content-between">
                                    <div class="d-flex justify-content-between">
                                        Check All <input type="checkbox" class="m-2" name="all_permission">

                                    </div>
                                </div>
                                @foreach ($permissions as $permission)
                                <div class="col-sm-2">
                                    <div class="p-2 border mb-2">
                                        <input type="checkbox" name="permission[{{ $permission->name }}]"
                                            value="{{ $permission->name }}" class='permission' {{
                                            in_array($permission->name, $rolePermissions) ? 'checked' : '' }}>
                                        <span>{{ $permission->name }}</span>
                                    </div>
                                </div>
                                @endforeach
                            </div>




                            <button type="submit" class="btn btn-primary">Save changes</button>
                            <a href="{{ route('roles.index') }}" class="btn btn-default">Back</a>
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

																if ($(this).is(':checked')) {
																				$.each($('.permission'), function() {
																								$(this).prop('checked', true);
																				});
																} else {
																				$.each($('.permission'), function() {
																								$(this).prop('checked', false);
																				});
																}

												});
								});
</script>





@endsection
