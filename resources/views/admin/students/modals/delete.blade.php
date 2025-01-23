<div class="modal fade" id="deleteUserModal" tabindex="-1" aria-labelledby="deleteUserModalLabel" aria-hidden="true">
  <div class="modal-dialog">
      <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title" id="deleteUserModalLabel">Delete User</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
              <p>Are you sure you want to delete this user?</p>
              <p><strong id="delete-user-name"></strong></p>
          </div>
          <div class="modal-footer">
              <form id="delete-user-form" method="POST">
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
  const deleteUserModal = document.getElementById('deleteUserModal');
  deleteUserModal.addEventListener('show.bs.modal', function (event) {
      var button = event.relatedTarget; // The button that triggered the modal
      var userName = button.getAttribute('data-name');
      var formAction = button.getAttribute('data-action');

      // Set the user name in the modal
      document.getElementById('delete-user-name').textContent = userName;

      // Set the form action URL
      document.getElementById('delete-user-form').action = formAction;
  });
</script>
