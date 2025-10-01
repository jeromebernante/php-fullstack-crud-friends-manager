<?php
if (!isset($component)) {
  include "../utils/functions.php";
  exit(render("../pages/404.php"));
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" type="image/png" href="assets/images/favicon.png">
  <title><?= $title ?></title>
  <!-- Bootstrap Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <!-- Bootstrap CSS (custom)-->
  <link rel="stylesheet" href="./assets/css/custom.css">
</head>