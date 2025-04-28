<!-- Create Booking Modal -->
<div class="modal fade" id="createBookingModal" tabindex="-1" aria-labelledby="createBookingModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createBookingModalLabel">Add New Booking</h5>
            </div>
            <div class="modal-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form id="createBookingForm" method="POST" action="{{ route('bookings.store') }}">
                    @csrf
                    
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="service_id" class="form-label">Service</label>
                            <select class="form-control" id="service_id" name="service_id" required>
                                <option value="" selected disabled>Select Service</option>
                                <!-- Options loaded dynamically -->
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="customer_id" class="form-label">Customer</label>
                            <select class="form-control" id="customer_id" name="customer_id" required>
                                <option value="" selected disabled>Select Customer</option>
                                <!-- Options loaded dynamically -->
                            </select>
                        </div>

                        <div class="col-md-12">
                            <label for="scheduled_at" class="form-label">Date</label>
                            <input type="datetime-local" class="form-control" id="scheduled_at" name="scheduled_at" required>
                        </div>

                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="submitBookingForm">Create Booking</button>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('submitBookingForm').addEventListener('click', function () {
        document.getElementById('createBookingForm').submit();
    });

    document.addEventListener("DOMContentLoaded", function () {
        getServices();
        getCustomers();

        function getServices() {
            fetch('fetch-services')
            .then(response => response.json())
                .then(services => {
                    const serviceSelect = document.getElementById("service_id");
                    serviceSelect.innerHTML = '<option value="" selected disabled>Select Service</option>';

                    services.forEach(service => {
                        const option = new Option(service.service_name, service.id);
                        serviceSelect.add(option);
                    });
                })
                .catch(error => console.error("Error loading services:", error));
        }

        function getCustomers() {
            fetch('fetch-customers')
            .then(response => response.json())
                .then(customers => {
                    const customerSelect = document.getElementById("customer_id");
                    customerSelect.innerHTML = '<option value="" selected disabled>Select Customer</option>';

                    customers.forEach(customer => {
                        const option = new Option(customer.name, customer.id);
                        customerSelect.add(option);
                    });
                })
                .catch(error => console.error("Error loading customers:", error));
        }

        const createModal = document.getElementById('createBookingModal');
        createModal.addEventListener('hidden.bs.modal', function () {
            document.getElementById('createBookingForm').reset();
        });
    });
    
</script>
