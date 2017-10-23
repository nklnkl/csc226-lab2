<?php
header('Content-type:application/json');

// Object
require_once('./object/item.php');

// Service

// Database
require_once('./json/item.php');

// Initialize response.
$status = 500;
$body = [];
$header = '';

// Method router.
switch ($_SERVER['REQUEST_METHOD']) {
  case 'GET':
    get();
    break;
  default:
    $status = 405;
    $header .= 'Allow: GET';
    return;
}

// Get router.
function get () {
  switch ( count($_GET) ) {
    case 0:
      getList();
      break;
    case 1:
      getItem();
      break;
    default:
      $status = 400;
      return;
  }
}

// Get item.
function getItem () {
  // Retrieve item.
  $item = ItemJson::get($_GET['id']);
  // if not found.
  if (gettype($item) != 'array') {
    $status = 404;
    return;
  }
  $status = 200;
  $body = $item;
  return;
}

// Get item list.
function getList () {
  // Retrieve item list.
  $list = ItemJson::list();
  // If not found.
  if (gettype($item) != 'array') {
    $status = 503;
    return;
  }
  $status = 200;
  $body = $list;
  return;
}

HTTP::respond($status, $body, $header);
?>
