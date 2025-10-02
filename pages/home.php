<?php
session_start();
require_once "./models/Friend.php";

// ✅ Require login (adjust based on your app's auth)
// if (!isset($_SESSION['user_id'])) {
//   http_response_code(403);
//   exit("Forbidden: Please log in first.");
// }

// ✅ Generate CSRF token (if not set yet)
if (empty($_SESSION['csrf_token'])) {
  $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// ---------------- CONTROLLER (Handle form actions) ----------------
if ($_SERVER["REQUEST_METHOD"] === "POST") {

  // ✅ Validate CSRF token
  if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
    http_response_code(403);
    exit("Invalid CSRF token");
  }

  if (isset($_POST["add_friend"])) {
    Friend::create($_POST);
    $_SESSION["toast"] = ["show" => true, "type" => "success", "message" => "Friend added!"];
    header("Location: " . $_SERVER["REQUEST_URI"]);
    exit;
  }

  if (isset($_POST["update_friend"])) {
    Friend::update($_POST["id"], $_POST);
    $_SESSION["toast"] = ["show" => true, "type" => "success", "message" => "Friend updated!"];
    header("Location: " . $_SERVER["REQUEST_URI"]);
    exit;
  }

  if (isset($_POST["delete_friend"])) {
    Friend::delete($_POST["id"]);
    $_SESSION["toast"] = ["show" => true, "type" => "success", "message" => "Friend deleted!"];
    header("Location: " . $_SERVER["REQUEST_URI"]);
    exit;
  }
}

// Load friends list
$friends = Friend::all();

render("./components/html-top.php", ["title" => "Project"]);
render("./components/add-friend-modal.php");
render("./components/edit-friend-modal.php");
render("./components/toast.php");
?>

<body class="min-vh-100 bg-secondary text-white">

  <div class="container min-vh-100 mx-auto bg-white p-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
      <h2>Friends List</h2>
      <!-- Add Friend Button -->
      <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addFriendModal">
        <i class="bi bi-person-plus"></i> Add Friend
      </button>
    </div>

    <!-- Friends Table -->
    <div class="table-responsive">
      <table class="table table-striped table-hover align-middle">
        <thead class="table-dark">
          <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Gender</th>
            <th>Phone</th>
            <th>City</th>
            <th>Email</th>
            <th>Created At</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php if (!empty($friends)): ?>
            <?php foreach ($friends as $friend): ?>
              <tr>
                <td><?= htmlspecialchars($friend['id']) ?></td>
                <td><?= htmlspecialchars($friend['name']) ?></td>
                <td><?= htmlspecialchars($friend['gender']) ?></td>
                <td><?= htmlspecialchars($friend['phone']) ?></td>
                <td><?= htmlspecialchars($friend['city']) ?></td>
                <td><?= htmlspecialchars($friend['email']) ?></td>
                <td><?= htmlspecialchars($friend['created_at']) ?></td>
                <td>
                  <a href="#" class="btn btn-sm btn-primary"
                    data-bs-toggle="modal" data-bs-target="#editFriendModal"
                    onclick="setUpdateFriendForm(<?= htmlspecialchars(json_encode($friend)) ?>)"
                    title="Edit Friend">
                    <i class="bi bi-pencil"></i>
                  </a>
                  <form method="POST" class="d-inline"
                    onsubmit="return confirm('Are you sure you want to delete this friend?');">
                    <input type="hidden" name="id" value="<?= $friend['id'] ?>">
                    <!-- ✅ CSRF token -->
                    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                    <button type="submit" name="delete_friend" class="btn btn-sm btn-danger" data-bs-toggle="tooltip" title="Delete Friend">
                      <i class="bi bi-trash"></i>
                    </button>
                  </form>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php else: ?>
            <tr>
              <td colspan="8" class="text-center text-muted">No friends found.</td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>

  </div>

</body>

<?php render("./components/html-bottom.php"); ?>

<script>
  function setUpdateFriendForm(friend) {
    document.getElementById('edit-id').value = friend.id;
    document.getElementById('edit-name').value = friend.name;
    document.getElementById('edit-gender').value = friend.gender;
    document.getElementById('edit-phone').value = friend.phone;
    document.getElementById('edit-city').value = friend.city;
    document.getElementById('edit-email').value = friend.email;
  }
</script>
