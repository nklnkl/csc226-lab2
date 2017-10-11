<?php
header('Content-type:application/json');
require_once('./json.php');
require_once('./http.php');

// Objects
require_once('./object/account.php');

// Services
require_once('./service/account.php');

// Endpoints
switch ($_SERVER['REQUEST_METHOD']) {
  // retrieve customer(s)
  case 'GET':
    get();
    break;
  // register customer(s)
  case 'POST';
    post();
    break;
  default:
    http_response_code(405);
    header('Allow: GET, POST');
}

function post () {
  $account = AccountService::register(getJsonPost());
  if (!is_array($account)) {
    $response = [];

    if ($account == 1 || $account == 10 || $account == 11 )
      $response['status'] = 500;
    else
      $response['status'] = 406;

    $response['message'] = $account;
  }


  exit(http_response_code(200));
}

// retrieve customer(s)
function get () {
  switch ( count($_GET) ) {
    // retrieve customers list
    case 0:
      getList();
      break;
    // retrieve customer by id
    case 1:
      getCustomer();
      break;
    default:
      http_response_code(400);
  }
}

/*
  end points
*/
function getCustomer () {
  // Retrieve customer.
  $result = getJson('customer', $_GET['id']);
  if ($result !== null) {
    $customer = new Customer();
    $customer->createFromArray($result);
    exit($customer->toJson());
  }
  // Otherwise return not found.
  exit(http_response_code(404));
}

function getList () {
  // Retrieve customer list.
  $list = getJson('customer', null);
  exit(json_encode($list));
}
?>
