@extends('layouts.app')
@section('title', 'permission Edit')
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
              

            </div>

        </div>
        <div class="bg-light p-4 rounded">
           
            <div class="lead">
                Editing permission.
            </div>

            <div class="container mt-4">

                <form method="POST" action="{{ route('permissions.update', $permission->id) }}">
                    @method('patch')
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input value="{{ $permission->name }}"
                            type="text"
                            class="form-control"
                            name="name"
                            placeholder="Name" required>

                        @if ($errors->has('name'))
                            <span class="text-danger text-left">{{ $errors->first('name') }}</span>
                        @endif
                    </div>

                    <button type="submit" class="btn btn-primary">Update permission</button>
                    <a href="{{ route('permissions.index') }}" class="btn btn-default">Back</a>
                </form>
            </div>

        </div>
      </div>

    </div>
  </div>
</section>

@endsection
