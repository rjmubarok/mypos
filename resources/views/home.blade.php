<?php
use App\Models\Income;
use App\Models\Expend;
?>

@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')
    <div class="pagetitle">
        <h1>@lang('dashboard.dashboard')</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('Dashboard') }}">@lang('dashboard.home')</a></li>
                <li class="breadcrumb-item active">@lang('dashboard.dashboard')</li>
            </ol>
        </nav>
        <section class="section dashboard">
            <div class="row">



                <div class="row">


                    <div class="col-xxl-4 col-md-4">
                        <div class="card info-card sales-card">



                            <div class="card-body bg-secondary  ">
                                <h5 class="card-title text-white">@lang('dashboard.total_student') <span></span></h5>

                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-people"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6 class="text-white small pt-1 fw-bold">{{ number_format($total_student, 2) }}
                                        </h6>


                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="col-xxl-4 col-md-4">
                        <div class="card info-card sales-card">



                            <div class="card-body bg-primary">
                                <h5 class="card-title text-white">@lang('dashboard.total_employee') <span></span></h5>

                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-people"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6 class="text-white small pt-1 fw-bold">{{ number_format($total_employee, 2) }}
                                        </h6>


                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="col-xxl-4 col-md-4">
                        <div class="card info-card sales-card">



                            <div class="card-body bg-warning">
                                <h5 class="card-title text-white">@lang('dashboard.todat_attandance') <span></span></h5>

                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-people"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6 class="text-white small pt-1 fw-bold">{{ number_format($todat_attandance, 2) }}
                                        </h6>


                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="col-xxl-4 col-md-4">
                        <div class="card info-card sales-card">
                            <div class="card-body bg-primary">
                                <h5 class="card-title text-white">@lang('dashboard.total_income_this_month') <span></span></h5>

                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-people"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6 class="text-white small pt-1 fw-bold">
                                            {{ number_format($total_income_this_month, 2) }}
                                        </h6>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="col-xxl-4 col-md-4">
                        <div class="card info-card sales-card">
                            <div class="card-body bg-dark">
                                <h5 class="card-title text-white">@lang('dashboard.total_expend_this_month') <span></span></h5>

                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-people"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6 class="text-white small pt-1 fw-bold">
                                            {{ number_format($total_expend_this_month, 2) }}
                                        </h6>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="col-xxl-4 col-md-4">
                        <div class="card info-card sales-card">
                            <div class="card-body bg-success">


                                <div class="d-flex align-items-center">
                                    <h5 class="card-title text-white"> মাসিক আয়ের হিসাব দেখতে এখানে ক্লিক করুন</h5>
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <a href="{{ route('monthly_report') }}" class="text-white">
                                            <i class="bi bi-arrow-right text-success"></i></a>
                                    </div>

                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="col-xxl-4 col-md-4">
                        <div class="card info-card sales-card">
                            <div class="card-body bg-danger">


                                <div class="d-flex align-items-center">
                                    <h5 class="card-title text-white"> মাসিক ব্যায়ের হিসাব দেখতে এখানে ক্লিক করুন</h5>
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <a href="{{ route('monthly_expend_report') }}" class="text-white">
                                            <i class="bi bi-arrow-right text-success"></i></a>
                                    </div>

                                </div>
                            </div>

                        </div>
                    </div>
                </div>


                <div class="row">
                    <h3 class=" text-center "> আয়ের খ্যাত বেসিস তথ্য</h3>
                    @forelse ($all_income_sectore as $data)
                        @php
                            $incomeTotal = \App\Models\Income::incomecount($data->id);
                            $datas = \App\Models\Income::where('income_sector_id', $data->id)->get();
                        @endphp
                        <div class="col-md-3">

                            <div class="card shadow rounded">

                                <div class="card-body">
                                    <h3 class="card-title text-center ">{{ $data->name }}</h3>
                                    <h2 class="card-title text-center p-0"> {{ number_format($incomeTotal, 2) }} &#2547;
                                    </h2>
                                    <div class="card-footer d-flex justify-content-between">
                                        <form action="{{ route('income_sector_data_print') }}" method="POST"
                                            class=" mr-2">
                                            @csrf
                                            <input type="hidden" name="income_sec_id" value="{{ $data->id }}">
                                            <button type="submit" data-id=" {{ $data->id }} " data-toggle="tooltip"
                                                title="Dawnload Info" data-placement="bottom"
                                                class="dltbtn btn btn-danger btn-sm">
                                                <i class="bi bi-file-earmark-arrow-down-fill"></i></button>
                                        </form>


                                        <button class="btn btn-success btn-sm" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapseIncome{{ $data->id }}" aria-expanded="false"
                                            aria-controls="collapseIncome{{ $data->id }}">
                                            আরও জানুন <i class="bi bi-eye"></i>
                                        </button>
                                    </div>
                                    <!-- Collapsible Income Table -->
                                    <div class="collapse mt-3" id="collapseIncome{{ $data->id }}">
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-sm mb-0">
                                                <thead class="table-light">
                                                    <tr>

                                                        <th>@lang('income.name')</th>

                                                        <th>@lang('income.date')</th>
                                                        <th>@lang('income.ammount')</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php $total = 0; @endphp
                                                    @forelse ($datas as $dataRow)
                                                        <tr>

                                                            <td>{{ $dataRow->name ?? '' }}</td>

                                                            <td>{{ $dataRow->date ?? '' }}</td>
                                                            <td>৳{{ number_format($dataRow->ammount, 2) }}</td>
                                                        </tr>
                                                        @php $total += $dataRow->ammount; @endphp
                                                    @empty
                                                        <tr>
                                                            <td colspan="3" class="text-center">কোনো তথ্য নেই</td>
                                                        </tr>
                                                    @endforelse
                                                    <tr>
                                                        <td colspan="2" class="text-end"><strong>মোট</strong></td>
                                                        <td><strong>৳{{ number_format($total, 2) }}</strong></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                    @endforelse
                </div>
                <div class="row">
                    <h3 class=" text-center "> ব্যায়ের খ্যাত বেসিস তথ্য</h3>
                    @forelse ($all_expend_sectore as $expend)
                        @php
                            $expendTotal = \App\Models\Expend::expendcount($expend->id);
                            $expends = \App\Models\Expend::where('expenditure_sector_id', $expend->id)->get();
                        @endphp
                        <div class="col-md-3">

                            <div class="card shadow rounded">

                                <div class="card-body">
                                    <h3 class="card-title text-center ">{{ $expend->name }}</h3>
                                    <h2 class="card-title text-center p-0"> {{ number_format($expendTotal, 2) }} &#2547;
                                    </h2>
                                    <div class="card-footer d-flex justify-content-between">
                                        <form action="{{ route('expend_sector_data_print') }}" method="POST"
                                            class=" mr-2">
                                            @csrf
                                            <input type="hidden" name="expend_sec_id" value="{{ $expend->id }}">
                                            <button type="submit" data-id=" {{ $expend->id }} " data-toggle="tooltip"
                                                title="Dawnload Info" data-placement="bottom"
                                                class="dltbtn btn btn-danger btn-sm">
                                                <i class="bi bi-file-earmark-arrow-down-fill"></i></button>
                                        </form>


                                        <button class="btn btn-success btn-sm" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapseExpend{{ $expend->id }}" aria-expanded="false"
                                            aria-controls="collapseExpend{{ $expend->id }}">
                                            আরও জানুন <i class="bi bi-eye"></i>
                                        </button>
                                    </div>
                                    <!-- Collapsible Income Table -->
                                    <div class="collapse mt-3" id="collapseExpend{{ $expend->id }}">
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-sm mb-0">
                                                <thead class="table-light">
                                                    <tr>

                                                        <th>@lang('income.name')</th>

                                                        <th>@lang('income.date')</th>
                                                        <th>@lang('income.ammount')</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php $total = 0; @endphp
                                                    @forelse ($expends as $dataRow)
                                                        <tr>

                                                            <td>{{ $dataRow->name ?? '' }}</td>

                                                            <td>{{ $dataRow->date ?? '' }}</td>
                                                            <td>৳{{ number_format($dataRow->ammount, 2) }}</td>
                                                        </tr>
                                                        @php $total += $dataRow->ammount; @endphp
                                                    @empty
                                                        <tr>
                                                            <td colspan="3" class="text-center">কোনো তথ্য নেই</td>
                                                        </tr>
                                                    @endforelse
                                                    <tr>
                                                        <td colspan="2" class="text-end"><strong>মোট</strong></td>
                                                        <td><strong>৳{{ number_format($total, 2) }}</strong></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                    @endforelse
                </div>
            </div>





            {{--  <h5 class="card-title">এই মাসে ব্যায়ের খ্যাত বেসিস তথ্য</h5>
            <div class="col-xxl-3 col-md-3">

                <table class="table  table-bordered">
                    <thead>
                        <tr>

                            <th>@lang('income_sector.name')</th>
                            <th>@lang('expend.ammount')</th>
                            <th>@lang('common.action')</th>

                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($all_expend_sectore as $data)
                            @php
                                $expendTotal = \App\Models\Expend::expendcount($data->id);
                            @endphp
                            <tr>

                                <td>{{ $data->name ?? '' }}</td>
                                <td> {{ number_format($expendTotal, 2) }}</td>


                                <td class="d-flex ">
                                    <form action="{{ route('expend_sector_data_print') }}" method="POST"
                                        class=" mr-2">
                                        @csrf
                                        <input type="hidden" name="expend_sec_id" value="{{ $data->id }}">
                                        <button type="submit" data-id=" {{ $data->id }} " data-toggle="tooltip"
                                            title="Dawnload Info" data-placement="bottom"
                                            class="dltbtn btn btn-danger btn-sm">
                                            <i class="bi bi-file-earmark-arrow-down-fill"></i></button>
                                    </form>
                                    <button type="submit" data-id="{{ $data->id }}" title="Show all info"
                                        class="Expend_show_btn btn btn-success btn-sm"><i class="bi bi-eye"></i></button>


                                </td>
                            </tr>
                        @empty
                        @endforelse


                    </tbody>
                </table>

            </div>  --}}
            <div class="col-xxl-8 col-md-8  sppinerss_ex display_expend">

            </div>
    </div>


    </section>

    </div><!-- End Page Title -->


@endsection
@section('scripts')


    <script type="text/javascript">
        $('.income_show_btn').on('click', function() {
            event.preventDefault();
            var income_sec_id = $(this).data('id');
            // alert(income_sec_id);
            $.ajax({
                url: "{{ route('income_sector_data') }}",
                type: "POST",
                data: {
                    income_sector_id: income_sec_id,
                    _token: '{{ csrf_token() }}'
                },
                beforeSend: function() {
                    $('.sppinerss').html(
                        '<i class="bi bi-arrow-clockwise text-danger fs-1"></i> <span class="text-danger fs-1">  Loadind..... </span>'
                    );
                },
                success: function(result) {
                    $('.sppinerss').html('');
                    $('.display_randData').html(result);

                }
            });


        });
    </script>

    <script type="text/javascript">
        $('.Expend_show_btn').on('click', function() {

            event.preventDefault();
            var expend_sec_id = $(this).data('id');
            // alert(income_sec_id);
            $.ajax({
                url: "{{ route('expend_sector_data') }}",
                type: "POST",
                data: {
                    expenditure_sector_id: expend_sec_id,
                    _token: '{{ csrf_token() }}'
                },
                beforeSend: function() {
                    $('.sppinerss_ex').html(
                        '<i class="bi bi-arrow-clockwise text-danger fs-1"></i> <span class="text-danger fs-1">  Loadind..... </span>'
                    );
                },
                success: function(result) {
                    $('.sppinerss_ex').html('');
                    $('.display_expend').html(result);

                }
            });


        });
    </script>


@endsection
