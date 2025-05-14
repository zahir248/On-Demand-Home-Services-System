<!-- Modal for updating booking payment status -->
<div class="modal fade" id="bookingPaymentStatusModal" tabindex="-1" role="dialog" aria-labelledby="bookingStatusModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="bookingStatusModalLabel">Update Payment Status</h5>
            </div>
            <form action="{{ route('bookings.update-payment-status') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="booking_id" id="booking_id_status">
                    
                    <div class="form-group">
                        <label for="payment_status">Payment Status</label>
                        <select class="form-control" id="payment_status" name="payment_status">
                            <option value="pending">Pending</option>
                            <option value="paid">Paid</option>
                            <option value="failed">Failed</option>
                        </select>
                    </div>
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update Status</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Listen for clicks on payment status badges
    document.querySelectorAll('[data-bs-target="#bookingPaymentStatusModal"]').forEach(badge => {
        badge.addEventListener('click', function() {
            const bookingId = this.getAttribute('data-id');
            const currentStatus = this.getAttribute('data-status');

            // Set booking ID and selected status
            document.getElementById('booking_id_status').value = bookingId;
            const statusSelect = document.getElementById('payment_status');
            for (let i = 0; i < statusSelect.options.length; i++) {
                statusSelect.options[i].selected = (statusSelect.options[i].value === currentStatus);
            }
        });
    });
});
</script>
