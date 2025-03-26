<!-- Create Category Modal -->
<div class="modal fade" id="createCategoryModal" tabindex="-1" aria-labelledby="createCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createCategoryModalLabel">Add New Category</h5>
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

                <form id="createCategoryForm" method="POST" action="{{ route('categories.store') }}">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="category_name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="category_name" name="name" required>
                    </div>

                    <div class="mb-3">
                        <label for="category_description" class="form-label">Description</label>
                        <textarea class="form-control" id="category_description" name="description" rows="3"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="submitCategoryForm">Create Category</button>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('submitCategoryForm').addEventListener('click', function () {
        document.getElementById('createCategoryForm').submit();
    });

    document.addEventListener("DOMContentLoaded", function () {
        const createModal = document.getElementById('createCategoryModal');
        createModal.addEventListener('hidden.bs.modal', function () {
            document.getElementById('createCategoryForm').reset();
        });
    });
</script>
