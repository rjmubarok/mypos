@extends('layouts.app')
@section('title', 'permissions ')
@section('content')

<section class="section">
    <div class="row">
        <div class="col-lg-12">

            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <a href="{{route('permissions.create')}}" class="btn btn-info btn-sm"><i
                                class="bi bi-plus-circle"></i>
                            @lang('common.create')</a>
                        <a href="{{route('permissions.index')}}" class="btn btn-info btn-sm"><i class="bi bi-list-task"></i>
                            @lang('common.list')</a>
                    </div>

                </div>


                <div class="card-body">
                    <table id="myTable"  class=" display table datatable table-bordered  table-hover">
                        <thead>
                            <tr>
                                <th >Name</th>
                                <th >Guard</th>
                                <th >Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($permissions as $permission)
                            <tr>
                                <td>{{ $permission->name }}</td>
                                <td>{{ $permission->guard_name }}</td>
                                <td class="d-flex">
                                    <a class="btn btn-info btn-sm m-1" href="{{ route('permissions.show', $permission->id) }}"><i
                                            class="bi bi-eye-fill" id=""></i></a>
                                    <a class="btn btn-primary btn-sm m-1" href="{{ route('permissions.edit', $permission->id) }}"><i
                                            class="bi bi-pencil-square"></i></a>
                                    <form action="{{ route('permissions.destroy', $permission->id) }}" method="POST" class=" m-1">
                                        @method('DELETE')
                                        @csrf
                                        <a href="" data-id=" {{ $permission->id }} " data-toggle="tooltip" title="Delete"
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
