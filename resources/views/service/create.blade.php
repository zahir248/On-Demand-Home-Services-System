<!-- Create Service Modal -->
<div class="modal fade" id="createServiceModal" tabindex="-1" aria-labelledby="createServiceModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createServiceModalLabel">Add New Service</h5>
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

                <form id="createServiceForm" method="POST" action="{{ route('services.store') }}">
                    @csrf
                    
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>

                        <div class="col-md-6">
                            <label for="service_price" class="form-label">Price (RM)</label>
                            <input type="number" class="form-control" id="service_price" name="price" required>
                        </div>

                        <div class="col-md-12">
                            <label for="service_description" class="form-label">Description</label>
                            <textarea class="form-control" id="service_description" name="description" rows="3"></textarea>
                        </div>

                        <div class="col-md-6">
                            <label for="service_category" class="form-label">Category</label>
                            <select class="form-control" id="service_category" name="category_id">
                                <option value="" selected disabled>Select a Category</option>
                                <!-- Options will be loaded dynamically -->
                            </select>
                        </div>

                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="submitServiceForm">Create Service</button>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('submitServiceForm').addEventListener('click', function () {
        document.getElementById('createServiceForm').submit();
    });

    document.addEventListener("DOMContentLoaded", function () {
        fetchCategories();

        function fetchCategories() {
            fetch('service-categories')  
            .then(response => response.json())
                .then(categories => {
                    const categorySelect = document.getElementById("service_category");
                    categorySelect.innerHTML = '<option value="" selected disabled>Select a Category</option>';

                    categories.forEach(category => {
                        const option = new Option(category.name, category.id);
                        categorySelect.add(option);
                    });
                })
                .catch(error => console.error("Error loading categories:", error));
        }

        const createModal = document.getElementById('createServiceModal');
        createModal.addEventListener('hidden.bs.modal', function () {
            document.getElementById('createServiceForm').reset();
        });
    });
</script>