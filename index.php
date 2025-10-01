<?php
include "./utils/functions.php";
include "./utils/database.php";
// Get current path from URL
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
// localhost directory or domain name
$domain = '/simple-structure';



// Routing
switch ($uri) {
  case $domain . '/':
    require __DIR__ . '/pages/home.php';
    break;

  case $domain . '/login':
    require __DIR__ . '/pages/login.php';
    break;

  case $domain . '/register':
    require __DIR__ . '/pages/register.php';
    break;

  default:
    require __DIR__ . '/pages/404.php';
    break;
}
?>