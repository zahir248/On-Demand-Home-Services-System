<!-- Modal HTML -->
<div class="modal fade" id="editServiceModal" tabindex="-1" aria-labelledby="editServiceModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editServiceModalLabel">Edit Service</h5>
            </div>
            <div class="modal-body">
                <form id="editServiceForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="editServiceId" name="id">

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="editServiceName" class="form-label">Name</label>
                            <input type="text" class="form-control" id="editServiceName" name="name" required>
                        </div>

                        <div class="col-md-6">
                            <label for="editPrice" class="form-label">Price (RM)</label>
                            <input type="number" class="form-control" id="editPrice" name="price" required>
                        </div>

                        <div class="col-md-12">
                            <label for="editDescription" class="form-label">Description</label>
                            <textarea class="form-control" id="editDescription" name="description" rows="3"></textarea>
                        </div>

                        <div class="col-md-6">
                            <label for="editCategory" class="form-label">Category</label>
                            <select class="form-control" id="editCategory" name="category_id">
                                <!-- Options will be loaded dynamically -->
                            </select>
                        </div>
                        
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="updateServiceButton">Update Service</button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {
    // Fetch categories when the page loads
    fetchCategories();

    document.querySelectorAll(".edit-service").forEach(button => {
        button.addEventListener("click", function () {
            let serviceId = this.getAttribute("data-id");

            // Fetch service data
            fetch(`/services/${serviceId}`)
                .then(response => response.json())
                .then(data => {
                    // Populate form fields
                    document.getElementById("editServiceId").value = data.id;
                    document.getElementById("editServiceName").value = data.service_name;
                    document.getElementById("editPrice").value = data.price;
                    document.getElementById("editDescription").value = data.description;

                    // Set the current category as selected
                    const categorySelect = document.getElementById("editCategory");
                    
                    // If the current category is not in the dropdown, add it
                    if (data.category) {
                        const existingOption = Array.from(categorySelect.options).find(
                            option => option.value == data.category.id
                        );

                        if (!existingOption) {
                            const newOption = new Option(
                                data.category.name, 
                                data.category.id, 
                                true, 
                                true
                            );
                            categorySelect.add(newOption);
                        } else {
                            categorySelect.value = data.category.id;
                        }
                    }

                    // Update form action to the correct service
                    document.getElementById("editServiceForm").action = `/services/${data.id}`;
                })
                .catch(error => console.error("Error loading service data for edit:", error));
        });
    });

    document.getElementById("updateServiceButton").addEventListener("click", function () {
        document.getElementById("editServiceForm").submit();
    });

    // Function to fetch and populate categories
    function fetchCategories() {
        fetch('service-categories')  // Adjust this endpoint to match your backend route
            .then(response => response.json())
            .then(categories => {
                const categorySelect = document.getElementById("editCategory");
                
                // Clear existing options
                categorySelect.innerHTML = '';

                // Add default "Select Category" option
                const defaultOption = new Option('Select Category', '', true, false);
                categorySelect.add(defaultOption);

                // Populate dropdown with categories
                categories.forEach(category => {
                    const option = new Option(category.name, category.id);
                    categorySelect.add(option);
                });
            })
            .catch(error => console.error("Error loading categories:", error));
    }
});
</script>