@extends('layouts.app')
@section('title', 'Sales list')
@section('content')

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                
                 <div class="d-flex justify-content-between">
                 <h4 class="mb-4">Sales List</h4>
                            <a href="{{ route('sale.create') }}" class="btn btn-info btn-sm"><i
                                    class="bi bi-plus-circle"></i> Add New Sales</a>

                        </div>
                <div class="card shadow-sm">
                    <div class="card-body table-responsive">
                        <table class="table table-bordered table-hover align-middle">
                            <thead class="table-dark">
                                <tr>
                                    <th>#</th>
                                    <th>Invoice No</th>
                                    <th>Customer</th>
                                    <th>Sold At</th>
                                    <th>Grand Total</th>
                                    <th>Paid</th>
                                    <th>Due</th>
                                    <th>Payment Status</th>
                                    <th>Status</th>
                                    <th width="160">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($sales as $sale)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $sale->invoice_no }}</td>
                                        <td>{{ $sale->customer->name ?? 'Walk-in Customer' }}</td>
                                        <td>{{ \Carbon\Carbon::parse($sale->sold_at)->format('d M Y, h:i A') }}</td>
                                        <td>{{ number_format($sale->grand_total, 2) }}</td>
                                        <td>{{ number_format($sale->paid_amount, 2) }}</td>
                                        <td>{{ number_format($sale->due_amount, 2) }}</td>
                                        <td>
                                            @if ($sale->payment_status == 'paid')
                                                <span class="badge bg-success">Paid</span>
                                            @elseif ($sale->payment_status == 'partial')
                                                <span class="badge bg-warning">Partial</span>
                                            @elseif ($sale->payment_status == 'unpaid')
                                                <span class="badge bg-danger">Unpaid</span>
                                            @else
                                                <span class="badge bg-secondary">Refunded</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($sale->status == 'completed')
                                                <span class="badge bg-primary">Completed</span>
                                            @elseif ($sale->status == 'draft')
                                                <span class="badge bg-secondary">Draft</span>
                                            @else
                                                <span class="badge bg-danger">Void</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('sale.show', $sale->id) }}"
                                                class="btn btn-sm btn-info">View</a>
                                            <a href="{{ route('sale.edit', $sale->id) }}"
                                                class="btn btn-sm btn-warning">Edit</a>
                                            <form action="{{ route('sale.destroy', $sale->id) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button onclick="return confirm('Are you sure?')"
                                                    class="btn btn-sm btn-danger">
                                                    Delete
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="10" class="text-center text-muted">No sales found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                        {{-- pagination --}}
                        {{--  <div class="mt-3">
                {{ $sales->links() }}
            </div>  --}}
                    </div>


                </div>
            </div>
    </section>

@endsection
@section('scripts')

    <script>
        // Delete Brand
        $(document).on('click', '.deleteBtn', function() {
            let id = $(this).data('id');
            let url = $(this).data("url");
            Swal.fire({
                title: "Are you sure?",
                text: "This action cannot be undone!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: url,
                        type: "POST",
                        data: {
                            _token: "{{ csrf_token() }}",
                            _method: "DELETE"
                        },
                        success: function(res) {
                            Swal.fire("Deleted!", res.message, "success");
                            // Optionally remove row from table
                            location.reload();
                        },
                        error: function(xhr) {
                            Swal.fire("Error!", "Something went wrong.", "error");
                        }
                    });
                }
            });

        });
        $(document).on('change', '.status-toggle', function() {
            let id = $(this).data('id');
            let status = $(this).is(':checked') ? 1 : 0;
            let label = $(this).closest('.form-check').find('.form-check-label');

            $.post('/product/status-update', {
                _token: '{{ csrf_token() }}',
                id: id,
                status: status
            }, function(res) {
                label.text(status == 1 ? 'Active' : 'Inactive')
                    .removeClass('text-success text-danger')
                    .addClass(status == 1 ? 'text-success' : 'text-danger');
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#productTable').DataTable();
        });
    </script>
@endsection
