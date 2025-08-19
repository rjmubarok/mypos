@extends('layouts.app')
@section('title', 'users')
@section('content')

<section class="section">
    <div class="row">
        <div class="col-lg-12">

            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        @if(auth()->user()->can('user-create'))
                        <a href="{{route('users.create')}}" class="btn btn-info btn-sm"><i
                                class="bi bi-plus-circle"></i>
                            @lang('common.create')</a>
                        @endif
                        @if(auth()->user()->can('user-list'))
                        <a href="{{route('users.index')}}" class="btn btn-info btn-sm"><i class="bi bi-list-task"></i>
                            @lang('common.list')</a>
                        @endif
                    </div>

                </div>
                <div class="card-body">
                    <table id="myTable" class="table datatable table-bordered  table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Username</th>
                                <th>Roles</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                            <tr>
                                <th>{{$loop->iteration}}</th>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->username }}</td>
                                <td>
                                    @foreach($user->roles as $role)
                                    <span class="badge bg-primary">{{ $role->name }}</span>
                                    @endforeach
                                </td>
                                <td>@if ( $user->status=='1')
                                    Active
                                    @else
                                    Inactive
                                    @endif

                                </td>
                                <td class="d-flex ">
                                    @can('user-edit')
                                    <a href="{{route('users.edit',$user->id)}}" class="btn btn-info btn-sm m-1"><i
                                            class="bi bi-pencil-square"></i></a>
                                    @endcan
                                    @can('user-show')
                                    <a href="{{route('users.show',$user->id)}}" class="btn btn-secondary btn-sm m-1"><i
                                            class="bi bi-eye"></i></a>
                                    @endcan
                                    @can('user-delete')
                                    <form action="{{ route('users.destroy', $user->id) }}" method="POST" class=" m-1">
                                        @method('DELETE')
                                        @csrf
                                        <a href="" data-id=" {{ $user->id }} " data-toggle="tooltip" title="Delete"
                                            data-placement="bottom" class="dltbtn btn btn-danger btn-sm"> <i
                                                class="bi bi-trash"></i></a>
                                    </form>
                                    @endcan

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
<script src="{{asset('assets/js/dataTables.bootstrap5.js')}}"></script>
<script src="{{asset('assets/js/dataTables.js')}}"></script>
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
<script>
    $(document).ready(function() {
    $('#myTable').DataTable();
} );
</script>
@endsection
