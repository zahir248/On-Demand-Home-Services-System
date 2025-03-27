<!-- Customer Details Modal -->
<div class="modal fade" id="customerModal" tabindex="-1" aria-labelledby="customerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="customerModalLabel">Customer Details</h5>
                <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
            </div>
            <div class="modal-body">
                <div class="text-center">
                    <img id="customerImage" src="" class="img-fluid mb-3" width="120" height="120" style="border-radius: 10px;">
                </div>
                <table class="table table-bordered">
                    <tr>
                        <th>ID</th>
                        <td id="customerId"></td>
                    </tr>
                    <tr>
                        <th>Name</th>
                        <td id="customerOwner"></td>
                    </tr>
                    <tr>
                        <th>Phone</th>
                        <td id="customerPhone"></td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td id="customerEmail"></td>
                    </tr>
                    <tr>
                        <th>Address</th>
                        <td id="customerAddress"></td>
                    </tr>
                    <tr>
                        <th>Registration Date</th>
                        <td id="customerDate"></td>
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
        document.querySelectorAll(".show-customer").forEach(button => {
            button.addEventListener("click", function () {
                let customerId = this.getAttribute("data-id");

                fetch(`/customers/${customerId}`)
                    .then(response => response.json())
                    .then(data => {
                        // Populate modal with customer details
                        document.getElementById("customerId").textContent = data.id;
                        document.getElementById("customerOwner").textContent = data.name;
                        document.getElementById("customerPhone").textContent = data.phone;
                        document.getElementById("customerEmail").textContent = data.email;
                        document.getElementById("customerAddress").textContent = data.address;
                        document.getElementById("customerDate").textContent = new Date(data.created_at).toLocaleDateString();

                        // Check if profile picture is available
                        let profileImage = data.profile_picture && data.profile_picture !== 'default-avatar.png' 
                            ? `/storage/${data.profile_picture}` 
                            : '/assets/img/default-avatar.png';

                        // Set the image source
                        document.getElementById("customerImage").src = profileImage;

                    })
                    .catch(error => console.error("Error loading customer data:", error));
            });
        });
    });
</script>