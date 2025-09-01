@extends('layouts.app')
@section('title', 'Users')

@section('content')

<section class="section">
    <div class="row">
        <div class="col-lg-12">

            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        @if(auth()->user()->can('user-create'))
                        <a href="{{ route('users.create') }}" class="btn btn-info btn-sm">
                            <i class="bi bi-plus-circle"></i> Create
                        </a>
                        @endif
                        @if(auth()->user()->can('user-list'))
                        <a href="{{ route('users.index') }}" class="btn btn-info btn-sm">
                            <i class="bi bi-list-task"></i> List
                        </a>
                        @endif
                    </div>
                </div>

                <div class="card-body">
                    <table id="myTable" class="table datatable table-bordered table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Roles</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                            <tr>
                                <th>{{ $loop->iteration }}</th>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>

                                <td>
                                    @foreach($user->roles as $role)
                                    <span class="badge bg-primary">{{ $role->name }}</span>
                                    @endforeach
                                </td>

                                <td>
                                    <div class="d-flex align-items-center">
                                        <span class="badge {{ $user->status == 1 ? 'bg-success' : 'bg-danger' }} me-2" id="status-text-{{ $user->id }}">
                                            {{ $user->status == 1 ? 'Active' : 'Inactive' }}
                                        </span>
                                        <div class="form-check form-switch mb-0">
                                            <input class="form-check-input status-toggle" type="checkbox"
                                                data-id="{{ $user->id }}" {{ $user->status == 1 ? 'checked' : '' }}>
                                        </div>
                                    </div>
                                </td>

                                <td class="d-flex">
                                    <a href="{{ route('users.edit', $user->id) }}" class="btn btn-info btn-sm m-1">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>

                                    <a href="{{ route('users.show', $user->id) }}" class="btn btn-secondary btn-sm m-1">
                                        <i class="bi bi-eye"></i>
                                    </a>

                                    <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="m-1">
                                        @method('DELETE')
                                        @csrf
                                         <button type="submit" class="btn btn-danger btn-sm "><i class="bi bi-trash"></i></button>
                                    </form>
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
<script src="{{ asset('assets/js/dataTables.bootstrap5.js') }}"></script>
<script src="{{ asset('assets/js/dataTables.js') }}"></script>

<script>
    $(document).ready(function() {
        $('#myTable').DataTable();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Delete button
        $('.dltbtn').click(function(e) {
            e.preventDefault();
            var form = $(this).closest('form');
            swal({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover this user!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) {
                    form.submit();
                }
            });
        });

        // Status toggle
        $(document).on('change', '.status-toggle', function() {
            let id = $(this).data('id');
            let status = $(this).is(':checked') ? 1 : 0;
            let badge = $('#status-text-' + id);

            $.post('{{ route("users.statusUpdate") }}', {id: id, status: status}, function(res) {
                if(res.success){
                    badge.text(status == 1 ? 'Active' : 'Inactive')
                        .removeClass('bg-success bg-danger')
                        .addClass(status == 1 ? 'bg-success' : 'bg-danger');
                }
            });
        });

    });
</script>
@endsection
