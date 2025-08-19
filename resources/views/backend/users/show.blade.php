@extends('layouts.app')
@section('title', 'User')
@section('content')

<section class="section">
    <div class="row">
        <div class="col-lg-12">

            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        @can('user-create')
                        <a href="{{route('users.create')}}" class="btn btn-info btn-sm"><i
                                class="bi bi-plus-circle"></i>
                            @lang('common.create')</a>
                        @endcan
                        @can('user-list')
                        <a href="{{route('users.index')}}" class="btn btn-info btn-sm"><i class="bi bi-list-task"></i>
                            @lang('common.list')</a>
                        @endcan
                        @can('user-edit')
                        <a href="{{route('users.edit',$user->id)}}" class="btn btn-info btn-sm"><i class="bi bi-list-task"></i>
                            @lang('common.list')</a>
                        @endcan

                    </div>

                </div>

            </div>
        </div>
        <div class="bg-light p-4 rounded">
            <h1>Show user</h1>
            <div class="lead">

            </div>

            <div class="container mt-4">
                <div>
                    Name: {{ $user->name }}
                </div>
                <div>
                    Email: {{ $user->email }}
                </div>
                <div>
                    Username: {{ $user->username }}
                </div>
            </div>

        </div>
        <div class="mt-4">
            <a href="{{ route('users.edit', $user->id) }}" class="btn btn-info">Edit</a>
            <a href="{{ route('users.index') }}" class="btn btn-default">Back</a>
        </div>

    </div>
    </div>
    </div>
</section>

@endsection
