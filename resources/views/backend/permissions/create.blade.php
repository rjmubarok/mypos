@extends('layouts.app')
@section('title', 'permission Add')
@section('content')

<section class="section">
  <div class="row">
    <div class="col-lg-12">

      <div class="card">
        <div class="card-header">
          <div class="d-flex justify-content-between">
            <a href="{{route('permissions.create')}}" class="btn btn-info btn-sm"><i class="bi bi-plus-circle"></i>
             Create</a>
            <a href="{{route('permissions.index')}}" class="btn btn-info btn-sm"><i class="bi bi-list-task"></i>List</a>
          </div>
            <div class="d-flex justify-content-between">
                        @can('permission-create')
                        <a href="{{ route('permissions.create') }}" class="btn btn-info btn-sm"><i
                                class="bi bi-plus-circle"></i>
                            @endcan

                           Create</a>
                        @can('permission-list')
                        <a href="{{ route('permissions.index') }}" class="btn btn-info btn-sm"><i class="bi bi-list-task"></i>
                           List</a>
                        @endcan

                    </div>

        </div>
        <div class="bg-light p-4 rounded">
            <h2>Add new permission</h2>
            <div class="lead">
                Add new permission.
            </div>
            <form action="{{ route('permissions.store') }}" method="POST">
                @csrf
                <table class="table" id="dynamicAddRemove">
                  <tr>
                    <td><input type="text" name="addMoreInputFields[0][name]" placeholder="Enter  Name"
                        class="form-control"/>
                        @if ($errors->has('name'))
                            <span class="text-danger text-left">{{ $errors->first('name') }}</span>
                        @endif
                    </td>
                    <td><button type="button" name="add" id="dynamic-ar" class="btn btn-sm btn-info btn-outline-primary">Add
                        More</button></td>
                  </tr>
                </table>
                <div class="d-flex justify-content-center">
                    <button type="submit" class="btn btn-success btn-sm m-2"><i class="bi bi-plus"></i>Save</button>
                    <a href="{{ route('permissions.index') }}" class="btn btn-default btn-outline-dark m-2"><i class="bi bi-arrow-return-left"></i>Back</a>
                </div>

              </form>
        </div>
      </div>

    </div>
  </div>
</section>

@endsection
@section('scripts')
@section('scripts')
<script type="text/javascript">
    $(document).ready(function () {
        var i = 0;

        // Add More button click
        $('#dynamic-ar').off('click').on('click', function () {
            ++i;
            $('#dynamicAddRemove').append('<tr><td><input type="text" name="addMoreInputFields[' + i + '][name]" placeholder="Enter Name" class="form-control" /></td><td><button type="button" class="btn btn-outline-danger remove-input-field">Remove</button></td></tr>');
        });

        // Remove button click
        $(document).off('click', '.remove-input-field').on('click', '.remove-input-field', function () {
            $(this).closest('tr').remove();
        });
    });
</script>
@endsection

@endsection
