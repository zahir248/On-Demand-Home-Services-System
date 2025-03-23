<!-- Modal for updating approval status -->
<div class="modal fade" id="approvalStatusModal" tabindex="-1" role="dialog" aria-labelledby="approvalStatusModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="approvalStatusModalLabel">Update Approval Status</h5>
                <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
            </div>
            <form action="{{ route('provider.update-status') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="provider_id" id="provider_id_status">
                    
                    <div class="form-group">
                        <label for="approval_status">Approval Status</label>
                        <select class="form-control" id="approval_status" name="approval_status">
                            <option value="Approved">Approved</option>
                            <option value="Rejected">Rejected</option>
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
    // Listen for clicks on approval status badges
    document.querySelectorAll('.approval-status-badge').forEach(badge => {
        badge.addEventListener('click', function() {
            // Get the provider ID and current status
            const providerId = this.getAttribute('data-id');
            const currentStatus = this.getAttribute('data-status');
            
            // Set the provider ID in the modal form
            document.getElementById('provider_id_status').value = providerId;
            
            // Set the current status as the selected option
            const statusSelect = document.getElementById('approval_status');
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