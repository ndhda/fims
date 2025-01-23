<!-- Modal to View Admin Details -->
<div class="modal fade" id="viewAdminModal" tabindex="-1" aria-labelledby="viewAdminModalLabel" aria-hidden="true">
  <div class="modal-dialog">
      <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title" id="viewAdminModalLabel">Admin Details</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
              <!-- Name -->
              <div class="mb-3">
                  <label for="view-admin-name" class="form-label">Name</label>
                  <input type="text" class="form-control" id="view-admin-name" disabled />
              </div>
              <!-- Staff ID -->
              <div class="mb-3">
                  <label for="view-admin-staff-id" class="form-label">Staff ID</label>
                  <input type="text" class="form-control" id="view-admin-staff-id" disabled />
              </div>
              <!-- Position -->
              <div class="mb-3">
                  <label for="view-admin-position" class="form-label">Position</label>
                  <input type="text" class="form-control" id="view-admin-position" disabled />
              </div>
              <!-- Email -->
              <div class="mb-3">
                  <label for="view-admin-email" class="form-label">Email</label>
                  <input type="email" class="form-control" id="view-admin-email" disabled />
              </div>
          </div>
          <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          </div>
      </div>
  </div>
</div>

<script>
  // Populate the modal with Admin details
  const viewAdminModal = document.getElementById('viewAdminModal');
  viewAdminModal.addEventListener('show.bs.modal', function (event) {
      var button = event.relatedTarget;

      // Set Admin details
      document.getElementById('view-admin-name').value = button.getAttribute('data-name');
      document.getElementById('view-admin-staff-id').value = button.getAttribute('data-staff-id');
      document.getElementById('view-admin-position').value = button.getAttribute('data-position');
      document.getElementById('view-admin-email').value = button.getAttribute('data-email');
  });
</script>
