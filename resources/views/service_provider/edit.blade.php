<div class="modal fade" id="editProviderModal" tabindex="-1" aria-labelledby="editProviderModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editProviderModalLabel">Edit Provider</h5>
                <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
            </div>
            <div class="modal-body">
                <form id="editProviderForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="editProviderId" name="id">

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="editBusinessName" class="form-label">Business Name</label>
                            <input type="text" class="form-control" id="editBusinessName" name="business_name">
                        </div>

                        <div class="col-md-6">
                            <label for="editOwner" class="form-label">Owner</label>
                            <input type="text" class="form-control" id="editOwner" name="name">
                        </div>

                        <div class="col-md-6">
                            <label for="editPhone" class="form-label">Phone</label>
                            <input type="tel" class="form-control" id="editPhone" name="phone" pattern="[0-9+\s]+" required>
                        </div>

                        <div class="col-md-6">
                            <label for="editEmail" class="form-label">Email</label>
                            <input type="email" class="form-control" id="editEmail" name="email" required>
                        </div>

                        <div class="col-md-12">
                            <label for="editAddress" class="form-label">Address</label>
                            <input type="text" class="form-control" id="editAddress" name="address">
                        </div>

                        <div class="col-md-12">
                            <label for="editProfilePicture" class="form-label">Image</label>
                            <input type="file" class="form-control" id="editProfilePicture" name="profile_picture" accept="image/*">
                        </div>
                        
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="updateProviderButton">Update Provider</button>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById("updateProviderButton").addEventListener("click", function () {
        document.getElementById("editProviderForm").submit();
    });
</script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Add event listeners for the edit buttons
        document.querySelectorAll(".edit-provider").forEach(button => {
            button.addEventListener("click", function () {
                let providerId = this.getAttribute("data-id");

                // Fetch provider data
                fetch(`/providers/${providerId}`)
                    .then(response => response.json())
                    .then(data => {
                        // Populate edit modal with provider details
                        document.getElementById("editProviderId").value = data.id;
                        document.getElementById("editBusinessName").value = data.business_name;
                        document.getElementById("editOwner").value = data.name;
                        document.getElementById("editPhone").value = data.phone;
                        document.getElementById("editEmail").value = data.email;
                        document.getElementById("editAddress").value = data.address;
                        
                        // Update form action to point to the correct provider
                        document.getElementById("editProviderForm").action = `/providers/${data.id}`;
                    })
                    .catch(error => console.error("Error loading provider data for edit:", error));
            });
        });
    });
</script>
