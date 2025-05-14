<!-- Modal for updating booking status -->
<div class="modal fade" id="bookingStatusModal" tabindex="-1" role="dialog" aria-labelledby="bookingStatusModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="bookingStatusModalLabel">Update Booking Status</h5>
            </div>
            <form action="{{ route('bookings.update-status') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="booking_id" id="booking_id">
                    
                    <div class="form-group">
                        <label for="status">Booking Status</label>
                        <select class="form-control" id="status" name="status">
                            <option value="pending">Pending</option>
                            <option value="confirmed">Confirmed</option>
                            <option value="completed">Completed</option>
                            <option value="canceled">Canceled</option>
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
    // Listen for clicks on status badges
    document.querySelectorAll('[data-bs-target="#bookingStatusModal"]').forEach(badge => {
        badge.addEventListener('click', function() {
            const bookingId = this.getAttribute('data-id');
            const currentStatus = this.getAttribute('data-status');

            // Set booking ID and selected status
            document.getElementById('booking_id').value = bookingId;
            const statusSelect = document.getElementById('status');
            for (let i = 0; i < statusSelect.options.length; i++) {
                statusSelect.options[i].selected = (statusSelect.options[i].value === currentStatus);
            }
        });
    });
});
</script>
