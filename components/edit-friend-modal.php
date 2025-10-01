<?php
if (!isset($component)) {
  include "../utils/functions.php";
  exit(render("../pages/404.php"));
}
?>

<!-- Edit Modal -->
<div class="modal fade" id="editFriendModal" tabindex="-1" aria-labelledby="editFriendModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content text-dark">
      <form method="POST">
        <div class="modal-header">
          <h5 class="modal-title" id="editFriendModalLabel">Edit Friend</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">

          <input type="hidden" name="id" id="edit-id">

          <div class="mb-3">
            <label for="edit-name" class="form-label">Name</label>
            <input type="text" class="form-control" id="edit-name" name="name" required>
          </div>

          <div class="mb-3">
            <label for="edit-gender" class="form-label">Gender</label>
            <select class="form-select" id="edit-gender" name="gender" required>
              <option value="Male">Male</option>
              <option value="Female">Female</option>
            </select>
          </div>

          <div class="mb-3">
            <label for="edit-phone" class="form-label">Phone</label>
            <input type="text" class="form-control" id="edit-phone" name="phone">
          </div>

          <div class="mb-3">
            <label for="edit-city" class="form-label">City</label>
            <input type="text" class="form-control" id="edit-city" name="city">
          </div>

          <div class="mb-3">
            <label for="edit-email" class="form-label">Email</label>
            <input type="email" class="form-control" id="edit-email" name="email">
          </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" name="update_friend" class="btn btn-primary">Save Changes</button>
        </div>
      </form>
    </div>
  </div>
</div>
