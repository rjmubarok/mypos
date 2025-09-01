@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')
    <div class="pagetitle">
        <h1>Dashboard</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->




    <section class="section dashboard">
        <div class="row">



            <div class="row">

                <!-- Customer Card -->
                <div class="col-xxl-4 col-md-4">
                    <div class="card info-card sales-card">



                        <div class="card-body">
                            <h5 class="card-title">Total Customer <span></span></h5>

                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-people"></i>
                                </div>
                                <div class="ps-3">
                                    <h6 class="text-success small pt-1 fw-bold">{{ number_format($totalcustomer, 2) }}</h6>


                                </div>
                            </div>
                        </div>

                    </div>
                </div><!-- End Sales Card -->
                <!-- Product Card -->
                <div class="col-xxl-4 col-md-4">
                    <div class="card info-card sales-card">



                        <div class="card-body">
                            <h5 class="card-title">Total Product <span></span></h5>

                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-cart"></i>
                                </div>
                                <div class="ps-3">
                                    <h6 class="text-success small pt-1 fw-bold">{{ number_format($totalproduct, 2) }}</h6>


                                </div>
                            </div>
                        </div>

                    </div>
                </div><!-- End Sales Card -->
                <div class="col-xxl-4 col-md-4">
                    <div class="card info-card sales-card">



                        <div class="card-body">
                            <h5 class="card-title">Total Category <span></span></h5>

                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-shop"></i>
                                </div>
                                <div class="ps-3">
                                    <h6 class="text-success small pt-1 fw-bold">{{ number_format($totalcategory, 2) }}</h6>


                                </div>
                            </div>
                        </div>

                    </div>
                </div><!-- End Sales Card -->
                <div class="col-xxl-4 col-md-4">
                    <div class="card info-card sales-card">



                        <div class="card-body">
                            <h5 class="card-title">Today Sales <span></span></h5>

                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="text-success ">&#2547;</i>
                                </div>
                                <div class="ps-3">
                                    <h6 class="text-success small pt-1 fw-bold"> {{ number_format($todaysals, 2) }}</h6>


                                </div>
                            </div>
                        </div>

                    </div>
                </div><!-- End Sales Card -->
                <div class="col-xxl-4 col-md-4">
                    <div class="card info-card sales-card">



                        <div class="card-body">
                            <h5 class="card-title">Total Invest <span></span></h5>

                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="text-success ">&#2547;</i>
                                </div>
                                <div class="ps-3">
                                    <h6 class="text-success small pt-1 fw-bold">
                                        {{ number_format($sumAllProductsStockandbuyingprice, 2) }}</h6>


                                </div>
                            </div>
                        </div>

                    </div>
                </div><!-- End Sales Card -->
                <div class="col-xxl-4 col-md-4">
                    <div class="card info-card sales-card">



                        <div class="card-body">
                            <h5 class="card-title">Expacted Earn <span></span></h5>

                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="text-success ">&#2547;</i>
                                </div>
                                <div class="ps-3">
                                    <h6 class="text-success small pt-1 fw-bold">
                                        {{ number_format($sumAllProductsStockandsellinggprice, 2) }}</h6>


                                </div>
                            </div>
                        </div>

                    </div>
                </div><!-- End Sales Card -->

                <div class="col-xxl-4 col-md-4">
                    <div class="card info-card sales-card">



                        <div class="card-body">
                            <h5 class="card-title">Last Month Sales <span></span></h5>

                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="text-success ">&#2547;</i>
                                </div>
                                <div class="ps-3">
                                    <h6 class="text-success small pt-1 fw-bold"> {{ number_format($lastmonth, 2) }}</h6>


                                </div>
                            </div>
                        </div>

                    </div>
                </div><!-- End Sales Card -->








                <!-- Top Selling -->
                <div class="col-12">
                    <div class="card top-selling overflow-auto">

                        <div class="filter">
                            <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                <li class="dropdown-header text-start">
                                    <h6>Filter</h6>
                                </li>

                                <li><a class="dropdown-item" href="#">Today</a></li>
                                <li><a class="dropdown-item" href="#">This Month</a></li>
                                <li><a class="dropdown-item" href="#">This Year</a></li>
                            </ul>
                        </div>

                        <div class="card-body pb-0">
                            <h5 class="card-title">Resent Selling <span>| Today</span></h5>

                            <table id="myTable" class=" display table datatable table-bordered  table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Date</th>
                                        <th>Product</th>
                                        <th>Product Price</th>
                                        <th>Photo</th>
                                        <th>Qty</th>
                                        <th>Total</th>
                                        <th>Paymaent Status</th>
                                        <th>Customer</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($recent_sales as $sale)
                                        @foreach ($sale->items as $item)
                                            <tr>
                                                <td>{{ $loop->parent->iteration }}</td>
                                                <td>{{ $sale->sold_at ?? '' }}</td>
                                                <td>{{ $item->product->name ?? 'N/A' }}</td>
                                                <td>{{ $item->product->selling_price ?? '0' }}</td>
                                                <td>
                                                    <img src="{{ asset($item->product->image ?? '') }}"
                                                        style="max-width:60px;">
                                                </td>
                                                <td>{{ $item->quantity ?? 0 }}</td>
                                                <td>{{ $item->total ?? 0 }}</td>
                                                <td>
                                                    @if ($sale->payment_status == 'Due')
                                                        <span class="badge bg-danger">{{ $sale->payment_status }}</span>
                                                    @elseif($sale->payment_status == 'Unpaid')
                                                        <span class="badge bg-warning">{{ $sale->payment_status }}</span>
                                                    @else
                                                        <span class="badge bg-success">{{ $sale->payment_status }}</span>
                                                    @endif
                                                </td>
                                                <td>{{ $sale->customer->name ?? 'Walk-in' }}</td>
                                            </tr>
                                        @endforeach
                                    @empty
                                        <tr>
                                            <td colspan="9">No recent sales found</td>
                                        </tr>
                                    @endforelse



                                </tbody>
                            </table>

                        </div>

                    </div>
                </div><!-- End Top Selling -->

            </div>
        </div>

    </section>


@endsection
@section('scripts')


    <script>
        $(document).ready(function() {
            $('#myTable').DataTable();
        });
    </script>
@endsection
