<!-- Edit Booking Modal -->
<div class="modal fade" id="editBookingModal" tabindex="-1" aria-labelledby="editBookingModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editBookingModalLabel">Edit Booking</h5>
            </div>
            <div class="modal-body">
                <form id="editBookingForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="editBookingId" name="id">

                    <div class="row g-3">
                        <div class="col-md-12">
                            <label for="editServiceSelect" class="form-label">Service</label>
                            <select class="form-control" id="editServiceSelect" name="service_id" >
                                <!-- Services will be loaded dynamically -->
                            </select>
                        </div>

                        <div class="col-md-12">
                            <label for="editBookingDate" class="form-label">Booking Date</label>
                            <input type="datetime-local" class="form-control" id="editBookingDate" name="scheduled_at" >
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="updateBookingButton">Update Booking</button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {
    fetchServices();

    document.querySelectorAll(".edit-booking").forEach(button => {
        button.addEventListener("click", function () {
            const bookingId = this.getAttribute("data-id");

            // Fetch booking data
            fetch(`/bookings/${bookingId}`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById("editBookingId").value = data.id;
                    
                    // Format the date to YYYY-MM-DD if needed
                    const scheduledAt = new Date(data.scheduled_at);
                    const formattedDate = scheduledAt.toISOString().split('T')[0];
                    document.getElementById("editBookingDate").value = formattedDate;

                    const serviceSelect = document.getElementById("editServiceSelect");

                    if (data.service) {
                        const existingOption = Array.from(serviceSelect.options).find(
                            option => option.value == data.service.id
                        );

                        if (!existingOption) {
                            const newOption = new Option(
                                data.service.service_name,  // Show the service name
                                data.service.id,
                                true,
                                true
                            );
                            serviceSelect.add(newOption);
                        } else {
                            serviceSelect.value = data.service.id;
                        }
                    }

                    document.getElementById("editBookingForm").action = `/bookings/${data.id}`;
                })
                .catch(error => console.error("Error loading booking data:", error));
        });
    });

    document.getElementById("updateBookingButton").addEventListener("click", function () {
        document.getElementById("editBookingForm").submit();
    });

    function fetchServices() {
        fetch('/fetch-services') 
            .then(response => response.json())
            .then(services => {
                const serviceSelect = document.getElementById("editServiceSelect");
                serviceSelect.innerHTML = '';

                const defaultOption = new Option('Select Service', '', true, false);
                serviceSelect.add(defaultOption);

                services.forEach(service => {
                    const option = new Option(service.service_name, service.id);
                    serviceSelect.add(option);
                });
            })
            .catch(error => console.error("Error loading services:", error));
    }
});
</script>
