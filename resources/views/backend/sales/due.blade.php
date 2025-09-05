{{-- resources/views/sales/due_index.blade.php --}}
@extends('layouts.app')

@section('title', 'Due Sales')

@section('content')
<section class="section">
    <div class="row">
        <div class="col-12">

            <div class="card shadow-sm border-0">
                <div class="card-header d-flex flex-column flex-lg-row align-items-lg-center gap-2 justify-content-between bg-white">
                    <div class="d-flex align-items-center gap-2">
                        <span class="fs-5 fw-semibold">🧾 Due Sales List</span>
                        <span class="badge bg-danger-subtle text-danger border border-danger-subtle">
                            {{ $sales->count() }} due
                        </span>
                    </div>

                    <div class="d-flex flex-wrap gap-2">
                        <div class="input-group input-group-sm" style="max-width: 280px">
                            <span class="input-group-text bg-light">Search</span>
                            <input type="text" id="tableSearch" class="form-control" placeholder="Invoice / Customer / Product">
                            <button class="btn btn-outline-secondary" type="button" id="clearSearch" title="Clear">×</button>
                        </div>
                        <div class="btn-group btn-group-sm" role="group" aria-label="Quick filters">
                            <button class="btn btn-outline-dark" data-filter="all">All</button>
                            <button class="btn btn-outline-success" data-filter="zero">Paid (Due = 0)</button>
                            <button class="btn btn-outline-danger" data-filter="due">Due &gt; 0</button>
                        </div>
                    </div>
                </div>

                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light sticky-top" style="top: 0; z-index: 1">
                                <tr class="text-nowrap">
                                    <th class="ps-3">#</th>
                                    <th>Invoice</th>
                                    <th>Date</th>
                                    <th>Customer</th>
                                    <th style="min-width:280px">Products</th>
                                    <th class="text-end">Total</th>
                                    <th class="text-end">Paid</th>
                                    <th class="text-end">Due</th>
                                    <th class="pe-3 text-center">Update Due</th>
                                </tr>
                            </thead>
                            <tbody id="dueTableBody">
                                @forelse($sales as $sale)
                                    @php
                                        $isCleared = floatval($sale->due_amount) <= 0;
                                        $products = $sale->items ?? collect();
                                    @endphp
                                    <tr data-due="{{ number_format($sale->due_amount,2,'.','') }}"
                                        class="{{ $isCleared ? 'table-success-subtle' : '' }}">
                                        <td class="ps-3">{{ $loop->iteration }}</td>

                                        <td class="fw-semibold">
                                            <span class="badge rounded-pill text-bg-dark">{{ $sale->invoice_no }}</span>
                                        </td>

                                        <td>
                                            {{ optional($sale->sold_at)->format('d M Y') ?? '-' }}
                                        </td>

                                        <td>
                                            {{ $sale->customer->name ?? 'Walk-in Customer' }}<br>
                                            @if(isset($sale->customer) && $sale->customer->phone)
                                                <small class="text-muted">{{ $sale->customer->phone }}</small>
                                            @endif
                                        </td>

                                        <td>
                                            @if($products->count())
                                                <div class="small lh-sm">
                                                    @foreach($products as $item)
                                                        <div class="d-flex justify-content-between gap-2 border-bottom py-1 small">
                                                            <span class="text-truncate" title="{{ $item->product->name ?? 'N/A' }}">
                                                                {{ $item->product->name ?? 'N/A' }}
                                                            </span>
                                                            <span class="text-nowrap">
                                                                x{{ $item->quantity ?? 1 }}
                                                            </span>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @else
                                                <span class="text-muted">—</span>
                                            @endif
                                        </td>

                                        <td class="text-end">
                                            {{ number_format($sale->total_amount ?? 0, 2) }}
                                        </td>

                                        <td class="text-end">
                                            {{ number_format($sale->paid_amount ?? (($sale->total_amount ?? 0) - ($sale->due_amount ?? 0)), 2) }}
                                        </td>

                                        <td class="text-end due-text fw-semibold {{ $isCleared ? 'text-success' : 'text-danger' }}">
                                            {{ number_format($sale->due_amount, 2) }}
                                        </td>

                                        <td class="pe-3">
                                            <div class="d-flex flex-wrap align-items-center gap-2 justify-content-center">
                                                <div class="input-group input-group-sm" style="max-width: 220px">
                                                    <span class="input-group-text">৳</span>
                                                    <input
                                                        type="number"
                                                        step="0.01"
                                                        min="0"
                                                        class="form-control due-input"
                                                        data-id="{{ $sale->id }}"
                                                        value="{{ number_format($sale->due_amount, 2, '.', '') }}"
                                                        {{ $isCleared ? '' : '' }}
                                                    >
                                                </div>

                                                <div class="form-check form-check-sm">
                                                    <input
                                                        type="checkbox"
                                                        class="form-check-input paid-checkbox"
                                                        data-id="{{ $sale->id }}"
                                                        id="paid_{{ $sale->id }}"
                                                        {{ $isCleared ? 'checked' : '' }}
                                                    >
                                                    <label class="form-check-label small" for="paid_{{ $sale->id }}">Paid</label>
                                                </div>

                                                <button
                                                    class="btn btn-success btn-sm update-due-btn d-inline-flex align-items-center gap-1"
                                                    data-id="{{ $sale->id }}"
                                                >
                                                    <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                                                    <span>Update</span>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="py-5">
                                            <div class="text-center text-muted">
                                                <div class="fs-1">🕊️</div>
                                                <div class="fw-semibold">No due sales found</div>
                                                <div class="small">Everything looks settled. Great job!</div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>

                            @if($sales->count())
                            <tfoot class="table-light">
                                @php
                                    $sumTotal = $sales->sum('total_amount');
                                    $sumPaid  = $sales->sum('paid_amount');
                                    $sumDue   = $sales->sum('due_amount');
                                @endphp
                                <tr class="fw-semibold">
                                    <td colspan="5" class="text-end">Total</td>
                                    <td class="text-end">{{ number_format($sumTotal,2) }}</td>
                                    <td class="text-end">{{ number_format($sumPaid,2) }}</td>
                                    <td class="text-end" id="sumDueCell">{{ number_format($sumDue,2) }}</td>
                                    <td></td>
                                </tr>
                            </tfoot>
                            @endif
                        </table>
                    </div>
                </div>

                <div class="card-footer d-flex justify-content-between align-items-center bg-white">
                    <small class="text-muted">Tip: Paid টিক দিলে Due 0 হয়ে যায়—Update চাপলেই সেভ হবে।</small>
                    {{-- যদি pagination থাকে, দেখান: --}}
                    @if(method_exists($sales, 'links'))
                        <div>{{ $sales->links() }}</div>
                    @endif
                </div>
            </div>

        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
    .table-success-subtle { background-color: rgba(25, 135, 84, 0.05) !important; }
    .table-danger-subtle { background-color: rgba(220, 53, 69, 0.05) !important; }
    .sticky-top th { box-shadow: inset 0 -1px 0 rgba(0,0,0,.05); }
    .form-check-sm .form-check-input { width: 1.05em; height: 1.05em; }
</style>
@endpush

@section('scripts')
<script>
(function(){
    const csrf = '{{ csrf_token() }}';

    // Search filter (client-side)
    const $search = $('#tableSearch');
    const $clear  = $('#clearSearch');
    const $tbody  = $('#dueTableBody');

    function rowMatches($tr, term){
        if(!term) return true;
        term = term.toLowerCase();
        return $tr.text().toLowerCase().includes(term);
    }

    function applySearch(){
        const term = $search.val().trim();
        $tbody.find('tr').each(function(){
            const $tr = $(this);
            $tr.toggle(rowMatches($tr, term));
        });
    }

    $search.on('input', debounce(applySearch, 150));
    $clear.on('click', function(){ $search.val(''); applySearch(); });

    // Quick filters
    $('[data-filter]').on('click', function(){
        const mode = $(this).data('filter');
        $tbody.find('tr').each(function(){
            const $tr  = $(this);
            const due  = parseFloat($tr.data('due') || 0);
            if(mode === 'all') { $tr.show(); }
            else if(mode === 'zero') { $tr.toggle(due <= 0); }
            else if(mode === 'due') { $tr.toggle(due > 0); }
        });
    });

    // Paid checkbox behavior (disable input & set 0)
    $(document).on('change', '.paid-checkbox', function(){
        const $row = $(this).closest('tr');
        const $input = $row.find('.due-input');

        if(this.checked){
            // store previous value to data attr
            if(!$input.data('prev')) $input.data('prev', $input.val());
            $input.val(0).prop('disabled', true);
        } else {
            // restore previous value if exists
            const prev = $input.data('prev');
            if(typeof prev !== 'undefined') $input.val(prev);
            $input.prop('disabled', false).focus().select();
        }
    });

    // Update Due (AJAX)
    $(document).on('click', '.update-due-btn', function(){
        const $btn = $(this);
        const $row = $btn.closest('tr');
        const saleId = $btn.data('id');

        const $spinner = $btn.find('.spinner-border');
        $spinner.removeClass('d-none');
        $btn.prop('disabled', true);

        const isPaid = $row.find('.paid-checkbox').is(':checked');
        const inputVal = parseFloat($row.find('.due-input').val() || 0);
        const newDue = isPaid ? 0 : Math.max(0, Number.isFinite(inputVal) ? inputVal : 0);

        $.ajax({
            url: '/sale/' + saleId + '/update-due',
            method: 'POST',
            dataType: 'json',
            data: { _token: csrf, due_amount: newDue },
            success: function(res){
                // Update UI
                $row.find('.due-text')
                    .text(newDue.toFixed(2))
                    .toggleClass('text-danger', newDue > 0)
                    .toggleClass('text-success', newDue <= 0);

                // reflect data-due for filters
                $row.attr('data-due', newDue.toFixed(2));

                // input & checkbox sync
                if(isPaid){
                    $row.find('.due-input').val(0).prop('disabled', true);
                    $row.addClass('table-success-subtle');
                } else {
                    $row.find('.due-input').prop('disabled', false);
                    $row.toggleClass('table-success-subtle', newDue <= 0);
                }

                // Update footer total due (recalc client-side)
                recalcDueSum();

                // SweetAlert if available, else fallback
                if(window.Swal){
                    Swal.fire({ icon: 'success', title: 'Updated', text: (res && res.message) ? res.message : 'Due updated successfully', timer: 1400, showConfirmButton: false });
                } else {
                    alert((res && res.message) ? res.message : 'Due updated successfully');
                }
            },
            error: function(xhr){
                let msg = 'Update failed. Please try again.';
                if(xhr?.responseJSON?.message) msg = xhr.responseJSON.message;
                if(window.Swal){
                    Swal.fire({ icon: 'error', title: 'Oops!', text: msg });
                } else {
                    alert(msg);
                }
            },
            complete: function(){
                $spinner.addClass('d-none');
                $btn.prop('disabled', false);
            }
        });
    });

    function recalcDueSum(){
        let sum = 0;
        $('#dueTableBody tr:visible').each(function(){
            const due = parseFloat($(this).attr('data-due') || '0');
            if(Number.isFinite(due)) sum += due;
        });
        $('#sumDueCell').text(sum.toFixed(2));
    }

    // Small utility: debounce
    function debounce(fn, delay){
        let t; return function(){ clearTimeout(t); t = setTimeout(() => fn.apply(this, arguments), delay); };
    }
})();
</script>
@endsection
