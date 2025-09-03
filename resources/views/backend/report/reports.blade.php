@extends('layouts.app')
@section('title', 'Sales Report')
@section('content')
<div class="container">
    <h2>Sales Reports</h2>

    <ul class="nav nav-tabs" id="reportTabs" role="tablist">
        <li class="nav-item"><a class="nav-link active" id="all-tab" data-bs-toggle="tab" href="#all">All Sales</a></li>
        <li class="nav-item"><a class="nav-link" id="date-tab" data-bs-toggle="tab" href="#date">Date-wise</a></li>
        <li class="nav-item"><a class="nav-link" id="customer-tab" data-bs-toggle="tab" href="#customer">Customer-wise</a></li>
        <li class="nav-item"><a class="nav-link" id="due-tab" data-bs-toggle="tab" href="#due">Due Sales</a></li>
    </ul>

    <div class="tab-content mt-3">
        <!-- All Sales -->
        <div class="tab-pane fade show active" id="all">
            <a href="{{ route('sales.report.pdf.all') }}" target="_blank" class="btn btn-success mb-2">Download PDF</a>
            @include('backend.report.partials.all', ['sales' => $allSales])
        </div>

        <!-- Date-wise -->
       <div class="tab-pane fade" id="date">
    <div class="card shadow-sm p-3">
        <h5 class="mb-3 text-primary">Generate Sales Report by Date</h5>

        <form id="dateForm" class="row g-2 align-items-end">
            @csrf
            <div class="col-sm-5">
                <label for="start_date" class="form-label">Start Date</label>
                <input type="date" name="start_date" class="form-control" required>
            </div>
            <div class="col-sm-5">
                <label for="end_date" class="form-label">End Date</label>
                <input type="date" name="end_date" class="form-control" required>
            </div>
            <div class="col-sm-2 d-grid">
                <button type="submit" class="btn btn-primary w-100">Generate</button>
            </div>
        </form>

        <div class="mt-3">
            <a href="#" id="datePDF" target="_blank" class="btn btn-success mb-3" style="display:none;">
                <i class="bi bi-file-earmark-pdf"></i> Download PDF
            </a>

            <div id="dateResults" class="table-responsive shadow-sm border rounded p-2">
                <!-- AJAX results will appear here -->
            </div>
        </div>
    </div>
</div>


        <!-- Customer-wise -->
        <div class="tab-pane fade" id="customer">
            <form id="customerForm">
                @csrf
                <select name="customer_id" required>
                    <option value="">Select Customer</option>
                    @foreach($customers as $customer)
                        <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                    @endforeach
                </select>
                <button type="submit" class="btn btn-primary">Generate</button>
            </form>
            <a href="#" id="customerPDF" target="_blank" class="btn btn-success mt-2" style="display:none;">Download PDF</a>
            <div id="customerResults" class="mt-3"></div>
        </div>

        <!-- Due Sales -->
        <div class="tab-pane fade" id="due">
            @include('backend.report.partials.due', ['dueSales' => $dueSales])
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function(){

    // Date-wise AJAX
    $('#dateForm').submit(function(e){
        e.preventDefault();
        $.ajax({
            url: "{{ route('sales.report.datewise') }}",
            type: "POST",
            data: $(this).serialize(),
            success: function(data){
                $('#dateResults').html(data);
                let start = $('input[name="start_date"]').val();
                let end   = $('input[name="end_date"]').val();
                $('#datePDF').attr('href', '/sales-report/pdf/datewise?start_date='+start+'&end_date='+end).show();
            }
        });
    });

    // Customer-wise AJAX
    $('#customerForm').submit(function(e){
        e.preventDefault();
        $.ajax({
            url: "{{ route('sales.report.customerwise') }}",
            type: "POST",
            data: $(this).serialize(),
            success: function(data){
                $('#customerResults').html(data);
                let customer = $('select[name="customer_id"]').val();
                $('#customerPDF').attr('href', '/sales-report/pdf/customerwise?customer_id='+customer).show();
            }
        });
    });

});
</script>
@endsection
