<!-- Provider Details Modal -->
<div class="modal fade" id="providerModal" tabindex="-1" aria-labelledby="providerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="providerModalLabel">Provider Details</h5>
                <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
            </div>
            <div class="modal-body">
                <div class="text-center">
                    <img id="providerImage" src="" class="img-fluid mb-3" width="120" height="120" style="border-radius: 10px;">
                </div>
                <table class="table table-bordered">
                    <tr>
                        <th>ID</th>
                        <td id="providerId"></td>
                    </tr>
                    <tr>
                        <th>Business Name</th>
                        <td id="providerBusiness"></td>
                    </tr>
                    <tr>
                        <th>Owner</th>
                        <td id="providerOwner"></td>
                    </tr>
                    <tr>
                        <th>Phone</th>
                        <td id="providerPhone"></td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td id="providerEmail"></td>
                    </tr>
                    <tr>
                        <th>Address</th>
                        <td id="providerAddress"></td>
                    </tr>
                    <tr>
                        <th>Registration Date</th>
                        <td id="providerDate"></td>
                    </tr>
                    <tr>
                        <th>Approval Status</th>
                        <td id="providerStatus"></td>
                    </tr>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        document.querySelectorAll(".show-provider").forEach(button => {
            button.addEventListener("click", function () {
                let providerId = this.getAttribute("data-id");

                fetch(`/providers/${providerId}`)
                    .then(response => response.json())
                    .then(data => {
                        // Populate modal with provider details
                        document.getElementById("providerId").textContent = data.id;
                        document.getElementById("providerBusiness").textContent = data.business_name;
                        document.getElementById("providerOwner").textContent = data.name;
                        document.getElementById("providerPhone").textContent = data.phone;
                        document.getElementById("providerEmail").textContent = data.email;
                        document.getElementById("providerAddress").textContent = data.address;
                        document.getElementById("providerDate").textContent = new Date(data.created_at).toLocaleDateString();
                        document.getElementById("providerStatus").innerHTML = `<span class="badge bg-${data.approval_status == 'Approved' ? 'success' : (data.approval_status == 'Pending' ? 'warning' : 'secondary')}">
                            ${data.approval_status}
                        </span>`;

                        // Check if profile picture is available
                        let profileImage = data.profile_picture && data.profile_picture !== 'default-avatar.png' 
                            ? `/storage/${data.profile_picture}` 
                            : '/assets/img/default-avatar.png';

                        // Set the image source
                        document.getElementById("providerImage").src = profileImage;

                    })
                    .catch(error => console.error("Error loading provider data:", error));
            });
        });
    });
</script>