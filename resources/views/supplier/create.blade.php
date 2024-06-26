<div class="modal fade" id="supplierModal" tabindex="-1" aria-labelledby="supplierModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="supplierModalLabel">Add Supplier</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="/supplier/store" method="post" class="row g-3" enctype="multipart/form-data">
              @csrf
              <div class="col-md-6">
                  <label for="supplier_name" class="form-label">Supplier Name</label>
                  <input type="text" class="form-control" id="supplier_name" name="supplier_name" required>
                  @error('supplier_name') <p class="text-danger">{{$message}}</p>@enderror
              </div>
              <div class="col-md-6">
                  <label for="contact_person" class="form-label">Contact Person</label>
                  <input type="text" class="form-control" id="contact_person" name="contact_person" required>
                  @error('contact_person') <p class="text-danger">{{$message}}</p>@enderror
              </div>
              <div class="col-md-6">
                  <label for="supplier_address" class="form-label">Supplier Address</label>
                  <input type="text" class="form-control" id="supplier_address" name="supplier_address" required>
                  @error('supplier_address') <p class="text-danger">{{$message}}</p>@enderror
              </div>
              <div class="col-md-6">
                  <label for="supplier_phone" class="form-label">Supplier Phone</label>
                  <input type="text" class="form-control" id="supplier_phone" name="supplier_phone" required>
                  @error('supplier_phone') <p class="text-danger">{{$message}}</p>@enderror
              </div>
              <div class="col-md-6">
                  <label for="supplier_email" class="form-label">Supplier Email</label>
                  <input type="email" class="form-control" id="supplier_email" name="supplier_email" required>
                  @error('supplier_email') <p class="text-danger">{{$message}}</p>@enderror
              </div>
              
              <div class="col-12">
                  <button type="submit" class="btn btn-outline-success">Submit</button>
                  <a href="/supplier/list" class="btn btn-outline-danger">Cancel</a>
              </div>
          </form>
        </div>
      </div>
    </div>
  </div>