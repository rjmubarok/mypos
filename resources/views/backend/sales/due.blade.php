@extends('layouts.app')
@section('title', 'Due Sales')
@section('content')

<section class="section">
    <div class="row">
        <div class="col-lg-12">

            <div class="card">
                <div class="card-body table-responsive">
                    <h4 class="mb-3">Due Sales List</h4>

                    <table class="table table-bordered table-hover align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>Invoice No</th>
                                <th>Customer</th>
                                <th>Products</th>
                                <th>Due Amount</th>
                                <th>Update Due</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($sales as $sale)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $sale->invoice_no }}</td>
                                    <td>{{ $sale->customer->name ?? 'Walk-in Customer' }}</td>
                                    <td>
                                        @foreach($sale->items as $item)
                                            {{ $item->product->name ?? 'N/A' }}@if(!$loop->last)<br>@endif
                                        @endforeach
                                    </td>
                                    <td class="due-text">{{ number_format($sale->due_amount, 2) }}</td>
                                    <td>
                                        <div class="input-group input-group-sm">
                                            <input type="number" step="0.01" class="form-control due-input" data-id="{{ $sale->id }}" value="{{ $sale->due_amount }}">
                                            <button class="btn btn-success btn-sm update-due-btn" data-id="{{ $sale->id }}">Update</button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted">No due sales found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                </div>
            </div>

        </div>
    </div>
</section>

@endsection

@section('scripts')
<script>
$(document).on('click', '.update-due-btn', function(){
    let btn = $(this);
    btn.prop('disabled', true); // prevent double clicks

    let saleId = btn.data('id');
    let row = btn.closest('tr');
    let newDue = row.find('.due-input').val();

    $.ajax({
        url: '/sale/' + saleId + '/update-due',
        type: 'POST',
        data: {
            _token: '{{ csrf_token() }}',
            due_amount: newDue
        },
        success: function(res){
            row.find('.due-text').text(parseFloat(newDue).toFixed(2));
            Swal.fire('Success', res.message, 'success');
        },
        complete: function(){
            btn.prop('disabled', false);
        }
    });
});
</script>
@endsection
