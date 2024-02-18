

<!-- Create New Material Modal -->
<div class="modal fade" id="exampleModalToggle" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
  <div class="modal-dialog modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalToggleLabel">New Material Request</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <!--  -->
        <div class="container">
        <form id="materialRequestForm"action="{{ route('requests.store') }}" method="POST">
            @csrf
            <!-- Material Request Information -->
            <div class="mb-3">
              <label for="requesterName" class="form-label">Request Name</label>
              <input type="text" class="form-control" id="requesterName" name="request_name" placeholder="example: Additional Cables">
            </div>
            <!-- Material Items -->
            <div id="materialItems">
              <div class="mb-3">
                <label for="materialName" class="form-label">Requested Material Name</label>
                <input type="text" class="form-control" id="materialName" name="materials[0][material_name]" placeholder="example: SATA Data Cables">
              </div>
              <div class="mb-3">
                <label for="requestedQuantity" class="form-label">Quantity</label>
                <input type="number" class="form-control" id="requestedQuantity" name="materials[0][quantity]" placeholder="example: 8">
              </div>
              <div class="mb-3">
                <label for="usageDescription" class="form-label">Description of Usage</label>
                <textarea class="form-control" id="usageDescription" name="materials[0][usage]"></textarea>
              </div>
            </div>
            <button class="btn btn-primary btn-block" id="addItem" type="button">Add More Material Request</button>
            <input type="hidden" id="custId" name="account_id" value="1">
            </div>
            </div>
            <div class="modal-footer">
              <button type="submit" class="btn btn-success" id="submitRequest">Submit Request</button>
            </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal" tabindex="-1" id="deleteModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Confirm Deletion</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Are you sure you want to delete this item?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="cancelDelete">Cancel</button>
        <button type="button" class="btn btn-danger" id="confirmDelete">Delete</button>
      </div>
    </div>
  </div>
</div>

<!-- View Details  & Update Material Modal -->
<div class="modal fade" id="materialModal" tabindex="-1" aria-labelledby="materialModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="materialModalLabel">Material Data</h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- display material data -->
                <form class="table" id="materialDataForm" method="POST">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                @if( auth()->user()->role === 'Warehouse')
                <button type="button" class="btn btn-danger" id="rejectButton">Reject</button>
                <button type="button" class="btn btn-success" id="approveButton">Approve</button>
                @endif
                <button type="button" class="btn btn-primary" id="saveMaterialChanges">Save changes</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="profileModal" tabindex="-1" role="dialog" aria-labelledby="profileModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h5 class="modal-title" id="profileModalLabel">Profile Settings</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <!-- Modal Body -->
            <div class="modal-body">
                <!-- Profile Settings Form -->
                <form action="{{ route('profile.update') }}" method="POST" id="profileForm">
                    @csrf
                    <!-- Name Field -->
                    <div class="form-group">
                        <label for="name">Name:</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ auth()->user()->name }}" disabled>
                    </div>
                    <!-- Password Field -->
                    <div class="form-group">
                        <label for="password">Password:</label>
                        <input type="password" class="form-control" id="password" name="password">
                    </div>
                    <!-- Confirm Password Field -->
                    <div class="form-group">
                        <label for="password_confirmation">Confirm Password:</label>
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                    </div>
                    <div id="password_confirmation_feedback" class="invalid-feedback"></div>
                    <!-- Submit Button -->
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </form>
            </div>
        </div>
    </div>
</div>