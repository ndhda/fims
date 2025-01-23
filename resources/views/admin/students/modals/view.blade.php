<!-- Modal to View Student Details -->
<div class="modal fade" id="viewStudentModal" tabindex="-1" aria-labelledby="viewStudentModalLabel" aria-hidden="true">
  <div class="modal-dialog">
      <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title" id="viewStudentModalLabel">Student Details</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
              <!-- Name Field -->
              <div class="mb-3">
                  <label for="view-name" class="form-label">Name</label>
                  <input type="text" class="form-control" id="view-name" readonly />
              </div>

              <!-- Student ID Field -->
              <div class="mb-3">
                  <label for="view-student-id" class="form-label">Student ID</label>
                  <input type="text" class="form-control" id="view-student-id" readonly />
              </div>

              <!-- Email Field -->
              <div class="mb-3">
                  <label for="view-email" class="form-label">Email</label>
                  <input type="email" class="form-control" id="view-email" readonly />
              </div>

              <!-- Semester Field -->
              <div class="mb-3">
                  <label for="view-semester" class="form-label">Semester</label>
                  <input type="text" class="form-control" id="view-semester" readonly />
              </div>

              <!-- Faculty Field -->
              <div class="mb-3">
                  <label for="view-faculty" class="form-label">Faculty</label>
                  <input type="text" class="form-control" id="view-faculty" readonly />
              </div>

              <!-- Programme Category Field -->
              <div class="mb-3">
                  <label for="view-programme-category" class="form-label">Programme Category</label>
                  <input type="text" class="form-control" id="view-programme-category" readonly />
              </div>

              <!-- Programme Level Field -->
              <div class="mb-3">
                  <label for="view-programme-level" class="form-label">Programme Level</label>
                  <input type="text" class="form-control" id="view-programme-level" readonly />
              </div>

              <!-- Programme Name Field -->
              <div class="mb-3">
                  <label for="view-programme-name" class="form-label">Programme Name</label>
                  <input type="text" class="form-control" id="view-programme-name" readonly />
              </div>
          </div>
          <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          </div>
      </div>
  </div>
</div>

<script>
  const viewStudentModal = document.getElementById('viewStudentModal');
  viewStudentModal.addEventListener('show.bs.modal', function (event) {
      var button = event.relatedTarget;

      // Set Student details
      document.getElementById('view-name').value = button.getAttribute('data-name');
      document.getElementById('view-student-id').value = button.getAttribute('data-student-id');
      document.getElementById('view-email').value = button.getAttribute('data-email');
      document.getElementById('view-semester').value = button.getAttribute('data-semester');
      document.getElementById('view-faculty').value = button.getAttribute('data-faculty');
      document.getElementById('view-programme-category').value = button.getAttribute('data-programme-category');
      document.getElementById('view-programme-level').value = button.getAttribute('data-programme-level');
      document.getElementById('view-programme-name').value = button.getAttribute('data-programme-name');
  });
</script>
