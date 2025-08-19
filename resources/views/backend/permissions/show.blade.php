@extends('layouts.app')
@section('title', 'permissions ')
@section('content')

<section class="section">
    <div class="row">
        <div class="col-lg-12">

            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        @can('permissions-list')
                        <a href="{{route('permissions.create')}}" class="btn btn-info btn-sm"><i
                            class="bi bi-plus-circle"></i>
                        @lang('common.create')</a>
                        @endcan
                            @can('permissions-list')
                            <a href="{{route('permissions.index')}}" class="btn btn-success btn-sm"><i class="bi bi-list-task"></i>
                                @lang('common.list')</a>
                            @endcan
                        @can('permissions-edit')
                        <a href="{{route('permissions.edit',$singlepermission->id)}}" class="btn btn-secondary btn-sm"><i class="bi bi-pen"></i>
                            @lang('common.edit')</a>
                        @endcan

                    </div>

                </div>


                <div class="card-body">
                    <table id="myTable"  class=" display table datatable table-bordered  table-hover">

                            <tr>
                                <th >Name</th>
                                <td>{{$singlepermission->name}} </td>
                            </tr>


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
