@extends('layouts.app')

@section('title', 'Date to Date Report')

@section('content')
<div class="container py-4">
    <h3 class="mb-4 text-primary">Date to Date Sales Report</h3>

    <!-- Search Form -->
    <form id="dateReportForm" class="row g-3 mb-3">
        @csrf
        <div class="col-md-4">
            <label for="startDate" class="form-label">Start Date</label>
            <input type="date" name="start_date" id="startDate" class="form-control" required>
        </div>
        <div class="col-md-4">
            <label for="endDate" class="form-label">End Date</label>
            <input type="date" name="end_date" id="endDate" class="form-control" required>
        </div>
        <div class="col-md-4 d-grid">
            <button type="submit" class="btn btn-primary mt-4">Search</button>
        </div>
    </form>

    <!-- Results -->
    <div id="dateReportResults" class="table-responsive shadow-sm border rounded p-2" style="min-height: 150px;">
        <p class="text-muted">Please select start and end date to generate report.</p>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(function(){
    $('#dateReportForm').submit(function(e){
        e.preventDefault();
console.log("Form submitted");
        $.ajax({
             url: "{{ route('sales.report.datewise') }}",
            type: "POST",
            data: $(this).serialize(),
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            beforeSend: function(){
                $('#dateReportResults').html('<p class="text-info">Loading...</p>');
            },
            success: function(response){
                $('#dateReportResults').html(response);
            },
            error: function(xhr){
                $('#dateReportResults').html('<div class="alert alert-danger">Something went wrong!</div>');
                console.error(xhr.responseText);
            }
        });
    });
});
</script>
@endsection
