<div class="modal fade" id="editCategoryModal" tabindex="-1" aria-labelledby="editCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editCategoryModalLabel">Edit Category</h5>
            </div>
            <div class="modal-body">
                <form id="editCategoryForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="editCategoryId" name="id">

                    <div class="mb-3">
                        <label for="editCategoryName" class="form-label">Name</label>
                        <input type="text" class="form-control" id="editCategoryName" name="name" required>
                    </div>

                    <div class="mb-3">
                        <label for="editCategoryDescription" class="form-label">Description</label>
                        <textarea class="form-control" id="editCategoryDescription" name="description" rows="3"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="updateCategoryButton">Update Category</button>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById("updateCategoryButton").addEventListener("click", function () {
        document.getElementById("editCategoryForm").submit();
    });

    document.addEventListener("DOMContentLoaded", function () {
        document.querySelectorAll(".edit-category").forEach(button => {
            button.addEventListener("click", function () {
                let categoryId = this.getAttribute("data-id");

                // Fetch category data
                fetch(`/categories/${categoryId}`)
                    .then(response => response.json())
                    .then(data => {
                        // Populate edit modal with category details
                        document.getElementById("editCategoryId").value = data.id;
                        document.getElementById("editCategoryName").value = data.name;
                        document.getElementById("editCategoryDescription").value = data.description ?? '';

                        // Update form action to point to the correct category
                        document.getElementById("editCategoryForm").action = `/categories/${data.id}`;
                    })
                    .catch(error => console.error("Error loading category data for edit:", error));
            });
        });
    });
</script>
