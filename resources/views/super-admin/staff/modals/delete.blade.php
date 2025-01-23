<!-- Modal to Confirm Deletion of Admin -->
<div class="modal fade" id="deleteAdminModal" tabindex="-1" aria-labelledby="deleteAdminModalLabel" aria-hidden="true">
  <div class="modal-dialog">
      <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title" id="deleteAdminModalLabel">Delete Admin</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
              <p>Are you sure you want to delete this Admin?</p>
              <p><strong id="delete-admin-name"></strong></p>
          </div>
          <div class="modal-footer">
              <form id="delete-admin-form" method="POST">
                  @csrf
                  @method('DELETE')
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                  <button type="submit" class="btn btn-danger">Delete</button>
              </form>
          </div>
      </div>
  </div>
</div>

<script>
  // Populate the modal for deleting Admin
  const deleteAdminModal = document.getElementById('deleteAdminModal');
  deleteAdminModal.addEventListener('show.bs.modal', function (event) {
      var button = event.relatedTarget;

      // Set Admin name and delete action
      var adminName = button.getAttribute('data-name');
      var formAction = button.getAttribute('data-action');

      document.getElementById('delete-admin-name').textContent = adminName;
      document.getElementById('delete-admin-form').action = formAction;
  });
</script>
