<?php
header('Content-type:application/json');
require_once('./json.php');
require_once('./http.php');

// Object
require_once('./object/account.php');

// Service
require_once('./service/account.php');

// Database
require_once('./json/account.php');

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
    http_response_code(405);
    header('Allow: GET, POST');
}

function post () {
  $response = [];
  $response['message'] = '';
  $response['status'] = 500;

  // Get user submitted data.
  $accountData = HTTP::getJsonPost();

  // Process account data.
  $registerResult = AccountService::register($accountData);
  if ($registerResult != 0) {
    switch ($registerResult) {
      case 1:
        $response['message'] = 'The account does not have a valid id. This is a server error';
        $response['status'] = 500;
        break;
      case 2:
        $response['message'] = 'You did not provide an email! Please fix and try again.';
        $response['status'] = 400;
        break;
      case 3:
        $response['message'] = 'You did not provide a password! Please fix and try again.';
        $response['status'] = 400;
        break;
      case 4:
        $response['message'] = 'You did not provide a first name! Please fix and try again.';
        $response['status'] = 400;
        break;
      case 5:
        $response['message'] = 'You did not provide a last name! Please fix and try again.';
        $response['status'] = 400;
        break;
      case 6:
        $response['message'] = 'You did not provide an address! Please fix and try again.';
        $response['status'] = 400;
        break;
      case 7:
        $response['message'] = 'You did not provide a city! Please fix and try again.';
        $response['status'] = 400;
        break;
      case 8:
        $response['message'] = 'You did not provide a state! Please fix and try again.';
        $response['status'] = 400;
        break;
      case 9:
        $response['message'] = 'You did not provide a zipcode! Please fix and try again.';
        $response['status'] = 400;
        break;
      case 10:
        $response['message'] = 'The account does not have a valid account level. This is a server error';
        $response['status'] = 500;
        break;
      case 11:
        $response['message'] = 'The account does not have keys initialized. This is a server error';
        $response['status'] = 500;
        break;
      default:
        $response['message'] = 'An internal server error has occured. A team of monkey ninjas was dispatched to fix it. Try again later.';
        $response['status'] = 500;
    }
    http_response_code($response['status']);
    exit(json_encode($response));
  }

  // Save account data
  $dbResult = AccountJson::save($accountData);
  if ($dbResult != 0) {
    switch ($dbResult) {
      case 1:
        $response['message'] = 'An internal server error has occured. A team of monkey ninjas was dispatched to fix it. Try again later.';
        $response['status'] = 500;
        break;
      case 2:
        $response['message'] = 'The email address is already used! Please fix and try again.';
        $response['status'] = 400;
        break;
      case 3:
        $response['message'] = 'An internal server error has occured. A team of monkey ninjas was dispatched to fix it. Try again later.';
        $response['status'] = 500;
        break;
    }
    http_response_code($response['status']);
    exit(json_encode($response));
  }

  http_response_code(200);
  $response['message'] = 'You signed up! Congrats! You can now log in.';
  exit(json_encode($response));
}

// retrieve account(s)
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
      http_response_code(400);
  }
}

function getCustomer () {
  // Retrieve account.
  $result = getJson('account', $_GET['id']);
  if ($result !== null) {
    $account = new Customer();
    $account->createFromArray($result);
    exit($account->toJson());
  }
  // Otherwise return not found.
  exit(http_response_code(404));
}

function getList () {
  // Retrieve account list.
  $list = getJson('account', null);
  exit(json_encode($list));
}
?>
