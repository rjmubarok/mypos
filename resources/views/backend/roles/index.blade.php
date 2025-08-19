@extends('layouts.app')
@section('title', 'roles')
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
                    <h1>Roles</h1>
                    <table id="myTable" class=" display table datatable table-bordered  table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($roles as $key => $role)
                            <tr>
                                <td>{{ $role->id }}</td>
                                <td>{{ $role->name }}</td>


                                <td class="d-flex">
                                    <a class="btn btn-info btn-sm m-1" href="{{ route('roles.show', $role->id) }}"><i
                                            class="bi bi-eye-fill" id=""></i></a>
                                    <a class="btn btn-primary btn-sm m-1" href="{{ route('roles.edit', $role->id) }}"><i
                                            class="bi bi-pencil-square"></i></a>
                                    <form action="{{ route('roles.destroy', $role->id) }}" method="POST" class=" m-1">
                                        @method('DELETE')
                                        @csrf
                                        <a href="" data-id=" {{ $role->id }} " data-toggle="tooltip" title="Delete"
                                            data-placement="bottom" class="dltbtn btn btn-danger btn-sm"> <i
                                                class="bi bi-trash"></i></a>
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
@section('scripts')
<script>
    $.ajaxSetup({
				        headers: {
				            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				        }
				    });
				    $('.dltbtn').click(function(e) {
				        var form = $(this).closest('form');
				        var dataId = $(this).data('id');
				        e.preventDefault();
				        swal({
				                title: "Are you sure?",
				                text: "Once deleted, you will not be able to recover this imaginary file!",
				                icon: "warning",
				                buttons: true,
				                dangerMode: true,
				            })
				            .then((willDelete) => {
				                if (willDelete) {
				                    form.submit();
				                    swal("Poof! Your imaginary file has been deleted!", {
				                        icon: "success",
				                    });
				                } else {
				                    swal("Your imaginary file is safe!");
				                }
				            });

				    });
</script>
@endsection
