<!-- Service Details Modal -->
<div class="modal fade" id="serviceModal" tabindex="-1" aria-labelledby="serviceModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="serviceModalLabel">Service Details</h5>
            </div>
            <div class="modal-body">
                <table class="table table-bordered">
                    <tr>
                        <th>ID</th>
                        <td id="serviceId"></td>
                    </tr>
                    <tr>
                        <th>Name</th>
                        <td id="serviceName"></td>
                    </tr>
                    <!-- <tr>
                        <th>Provider</th>
                        <td id="serviceProvider"></td>
                    </tr> -->
                    <tr>
                        <th>Category</th>
                        <td id="serviceCategory"></td>
                    </tr>
                    <tr>
                        <th>Price (RM)</th>
                        <td id="servicePrice"></td>
                    </tr>
                    <tr>
                        <th>Description</th>
                        <td id="serviceDescription"></td>
                    </tr>
                    <tr>
                        <th>Registration Date</th>
                        <td id="serviceDate"></td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td id="serviceStatus"></td>
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
        document.querySelectorAll(".show-service").forEach(button => {
            button.addEventListener("click", function () {
                let serviceId = this.getAttribute("data-id");

                fetch(`/services/${serviceId}`)
                    .then(response => response.json())
                    .then(data => {
                        // Populate modal with service details
                        document.getElementById("serviceId").textContent = data.id ?? '-';
                        document.getElementById("serviceName").textContent = data.service_name ?? '-';
                        // document.getElementById("serviceProvider").textContent = data.provider?.business_name ?? 'N/A';
                        document.getElementById("serviceCategory").textContent = data.category?.name ?? 'N/A';
                        document.getElementById("servicePrice").textContent = data.price ? `${parseFloat(data.price).toFixed(2)}` : '-';
                        document.getElementById("serviceDescription").textContent = data.description ?? '-';
                        document.getElementById("serviceDate").textContent = data.created_at ? new Date(data.created_at).toLocaleDateString() : '-';
                        document.getElementById("serviceStatus").innerHTML = `<span class="badge bg-${data.status == 'active' ? 'success' : 'secondary'}">
                            ${data.status ? data.status.charAt(0).toUpperCase() + data.status.slice(1) : '-'}
                        </span>`;
                    })
                    .catch(error => console.error("Error loading service data:", error));
            });
        });
    });
</script>
