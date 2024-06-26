<div class="modal fade" id="editCategoryModal" tabindex="-1" aria-labelledby="editCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editCategoryModalLabel">Edit Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="/category/update/{{ $category->category_id }}" method="post" class="row g-3">
                    @csrf
                    @method('PUT')
                    <div class="col-md-12">
                        <label for="category_name" class="form-label">Category Name</label>
                        <input type="text" class="form-control" id="category_name" name="category_name" value="{{ $category->category_name }}" required>
                        @error('category_name') <p class="text-danger">{{$message}}</p>@enderror
                    </div>
                    
                    <div class="col-12">
                        <button type="submit" class="btn btn-outline-success">Update</button>
                        <a href="/category/list" class="btn btn-outline-danger">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>