<div class="modal fade" id="paymentModal_{{ $billing->id }}" tabindex="-1" aria-labelledby="paymentModalLabel_{{ $billing->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="paymentModalLabel_{{ $billing->id }}">Detail Tagihan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @include('siswa.payment', ['billing' => $billing])
            </div>
        </div>
    </div>
</div>
