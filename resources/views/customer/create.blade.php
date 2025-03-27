<!-- Create Customer Modal -->
<div class="modal fade" id="createCustomerModal" tabindex="-1" aria-labelledby="createCustomerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createCustomerModalLabel">Add New Customer</h5>
                <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
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

                <form id="createCustomerForm" method="POST" action="{{ route('customers.store') }}" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="row">
                        <!-- First Column -->
                        <div class="col-md-6">

                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>

                            <div class="mb-3">
                                <label for="phone" class="form-label">Phone</label>
                                <input type="tel" class="form-control" id="phone" name="phone" pattern="[0-9+\s]+" required>
                            </div>
                        </div>
                        
                        <!-- Second Column -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>

                            <div class="mb-3">
                                <label for="address" class="form-label">Address</label>
                                <input type="text" class="form-control" id="address" name="address" required>
                            </div>

                        </div>
                    </div>
                    
                    <!-- Full width for the Profile Picture (since it's special) -->
                    <div class="row">
                        <div class="col-12">
                            <div class="mb-3">
                                <label for="profile_picture" class="form-label">Profile Picture</label>
                                <input type="file" class="form-control" id="profile_picture" name="profile_picture" accept="image/*">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="submitCustomerForm">Create Customer</button>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('submitCustomerForm').addEventListener('click', function () {
        document.getElementById('createCustomerForm').submit();
    });
</script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Reset form when modal is hidden
        const createModal = document.getElementById('createCustomerModal');
        createModal.addEventListener('hidden.bs.modal', function () {
            document.getElementById('createCustomerForm').reset();
        });
    });
</script>