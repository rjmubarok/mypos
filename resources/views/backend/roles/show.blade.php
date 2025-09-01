@extends('layouts.app')
@section('title','Role Details')
@section('content')
<section class="section">
    <div class="row">
        <div class="col-lg-6">
            <div class="card p-3">
                <h4>Role Details</h4>
                <div><strong>ID:</strong> {{ $role->id }}</div>
                <div><strong>Name:</strong> {{ $role->name }}</div>
                <div><strong>Permissions:</strong><br>
                    @foreach($rolePermissions as $perm)
                        <span class="badge bg-success">{{ $perm->name }}</span>
                    @endforeach
                </div>
                <a href="{{ route('roles.index') }}" class="btn btn-secondary mt-3">Back</a>
            </div>
        </div>
    </div>
</section>
@endsection