<!-- Modal for updating service status -->
<div class="modal fade" id="serviceStatusModal" tabindex="-1" role="dialog" aria-labelledby="serviceStatusModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="serviceStatusModalLabel">Update Service Status</h5>
            </div>
            <form action="{{ route('service.update-status') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="service_id" id="service_id_status">
                    
                    <div class="form-group">
                        <label for="service_status">Service Status</label>
                        <select class="form-control" id="service_status" name="service_status">
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
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
    // Listen for clicks on service status badges
    document.querySelectorAll('.service-status-badge').forEach(badge => {
        badge.addEventListener('click', function() {
            // Get the service ID and current status
            const serviceId = this.getAttribute('data-id');
            const currentStatus = this.getAttribute('data-status');
            
            // Set the service ID in the modal form
            document.getElementById('service_id_status').value = serviceId;
            
            // Set the current status as the selected option
            const statusSelect = document.getElementById('service_status');
            for (let i = 0; i < statusSelect.options.length; i++) {
                if (statusSelect.options[i].value === currentStatus) {
                    statusSelect.options[i].selected = true;
                    break;
                }
            }
        });
    });
});
</script>
