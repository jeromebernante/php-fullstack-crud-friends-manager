<?php

if (!isset($component)) {
  include "../utils/functions.php";
  exit(render("../pages/404.php"));
}

// Default toast
if (!isset($_SESSION["toast"])) {
  $_SESSION["toast"] = [
    "show" => false,
    "type" => "",
    "message" => ""
  ];
}
?>
<!-- Toast Container -->
<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 1100">
  <div id="liveToast" class="toast align-items-center text-bg-<?= $_SESSION["toast"]["type"] ?? "primary" ?> border-0 <?= ($_SESSION["toast"]["show"]) ? "show" : "" ?>" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="d-flex">
      <div class="toast-body">
        <?= $_SESSION["toast"]["message"] ?? "" ?>
      </div>
      <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
  </div>
</div>

<?php
// Reset toast after rendering
if (isset($_SESSION["toast"])) {
  $_SESSION["toast"]["show"] = false;
}
?>