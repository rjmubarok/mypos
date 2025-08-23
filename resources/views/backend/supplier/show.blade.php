@extends('layouts.app')
@section('title', 'Supplier Show')
@section('content')
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('supplier.create') }}" class="btn btn-info btn-sm"><i
                                    class="bi bi-plus-circle"></i>
                                Create new</a>
                            <a href="{{ route('supplier.index') }}" class="btn btn-info btn-sm"><i
                                    class="bi bi-list-task"></i>
                                List</a>
                        </div>

                    </div>
                    <div class="card-body">

                        <div class="card-body">
                            <h5 class="text-center"> Supplier Information </h5>
                            <table class="table table-bordered  table-hover">
                                <tr>
                                    <th>
                                        Supplier Name
                                    </th>
                                    <td>
                                        {{ $supplier->name ?? '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        Supplier Email
                                    </th>
                                    <td>
                                        {{ $supplier->email ?? '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        Supplier Phone
                                    </th>
                                    <td>
                                        {{ $supplier->phone ?? '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                       Address
                                    </th>
                                    <td>
                                        {{ $supplier->address ?? '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                      Shop Name
                                    </th>
                                    <td>
                                        {{ $supplier->shopname ?? '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                      Photo
                                    </th>
                                    <td>
                                        <img class="" style="max-width: 60px; "src="{{ asset($supplier->photo) }}">
                                    </td>
                                </tr>


                                <tr>
                                    <th>
                                        Modified At
                                    </th>

                                    <td>{{ \App\Models\User::where('id', $supplier->modified_at)->value('name') }}
                                    </td>

                                </tr>
                                <tr>
                                    <th>
                                        Modified By
                                    </th>

                                    <td>{{ \App\Models\User::where('id', $supplier->modified_by)->value('name') }}
                                    </td>

                                </tr>

                                <tr>
                                    <th>
                                       Created Time 
                                    </th>
                                    <td>
                                        {{ $supplier->created_at->format('M-d-Y (h:m:s)') ?? '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                       Updated Time
                                    </th>
                                    <td>{{ $supplier->updated_at->format('M-d-Y (h:m:s)') ?? '' }}</td>
                                </tr>

                            </table>


                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection
