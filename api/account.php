<?php
header('Content-type:application/json');

// HTTP
require('./http.php');

// Object
require_once(dirname(__FILE__) . '/object/account.php');

// Service
require_once(dirname(__FILE__) . '/service/http.php');
require_once(dirname(__FILE__) . '/service/account.php');

// Database
require_once(dirname(__FILE__) . '/json/account.php');

// Initialize response.
$status = 500;
$body = [];
$header = '';

// Request method router.
switch ($_SERVER['REQUEST_METHOD']) {
  // retrieve account(s)
  case 'GET':
    get();
    break;
  // register account(s)
  case 'POST';
    post();
    break;
  default:
    $status = 405;
    $header .= 'Allow: GET, POST';
}

/*
  error code (only if error response is returned)
    client
      1 - Account with email already exists.
    service
      1 - An email was not provided. (Client error)
      2 - A password was not provided. (Client error)
      3 - A first name was not provided. (Client error)
      4 - A last name was not provided. (Client error)
      5 - A address was not provided. (Client error)
      6 - A city was not provided. (Client error)
      7 - A state was not provided. (Client error)
      8 - A zipcode was not provided. (Client error)
    db
      -1 - Internal server error at the service level. Not expected (Critical server error)
      1 - Internal server error at the service level. Not expected (Critical server error)
      2 - Account with email already exists. (Client error)
      3 - Account with id already exists. (Server error)
*/
function post () {
  // Get user submitted data.
  $accountData = HTTP::getJsonPost();

  // Check if account with email already exists.
  $existingAccount = AccountJson::getByEmail($accountData['email']);
  // Client error.
  if (gettype($existingAccount) == 'array') {
    $status = 400;
    $body['level'] = 'client';
    $body['code'] = 1;
    return;
  }

  // Process account data.
  $register = AccountService::register($accountData);
  // Service error.
  if ( gettype($register) != 'array' ) {
    $status = 400;
    $body['level'] = 'service';
    $body['code'] = $register;
    return;
  }

  // Save account data
  $db = AccountJson::save($register);
  // Db error.
  if ($db != 0) {
    if ($db == 1 || $db == 3)
      $status = 500;
    else
      $status = 400;
    $body['level'] = 'database';
    $body['code'] = $db;
    return;
  }
  $status = 200;
  return;
}

// Get router.
function get () {
  switch ( count($_GET) ) {
    // retrieve accounts list
    case 0:
      getList();
      break;
    // retrieve account by id
    case 1:
      getCustomer();
      break;
    default:
      $status = 400;
      return;
  }
}

// Get customer.
function getCustomer () {
  // Retrieve account.
  $account = AccountJson::get($_GET['id']);
  // if not found.
  if (gettype($account) != 'array') {
    $status = 404;
    return;
  }
  $status = 200;
  $body = $account;
  return;
}

// Get customer list.
function getList () {
  // Retrieve account list.
  $list = AccountJson::list();
  // If not found.
  if (gettype($account) != 'array') {
    $status = 503;
    return;
  }
  $status = 200;
  $body = $list;
  return;
}

HTTP::respond($status, $body, $header);
?>
