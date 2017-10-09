<?php
header('Content-type:application/json');
require_once('./json.php');
require_once('./http.php');
require_once('./objects/customer.php');

/*
  routes
*/

switch ($_SERVER['REQUEST_METHOD']) {
  case 'GET':
    get();
    break;
  case 'POST';
    post();
    break;
  default:
    http_response_code(405);
    header('Allow: GET');
}

function get () {
  switch ( count($_GET) ) {
    case 0:
      getList();
      break;
    case 1:
      getCustomer();
      break;
    default:
      //http_response_code(400);
  }
}

/*
  end points
*/

function post () {
  // Get latest id.
  $id = getNewId('customer');

  $data = getJsonPost();
  $newCustomer = new Customer();
  $newCustomer->setId( $id );
  $newCustomer->setEmail( $data['email'] );
  $newCustomer->setPassword( $data['password'] );
  $newCustomer->setFirstName( $data['firstName'] );
  $newCustomer->setLastName( $data['lastName'] );
  $newCustomer->setAddress( $data['address'] );
  $newCustomer->setCity( $data['city'] );
  $newCustomer->setState( $data['state'] );
  $newCustomer->setZipcode( $data['zipcode'] );
  $newCustomer->setLevel( 0 );

  // Check if customer already exists.
  $list = getJson('customer');
  foreach($list as $customer) {
    if ($customer['email'] == $newCustomer->getEmail())
      exit(http_response_code(409));
  }

  // If not, add to list and save to json.
  array_push($list, $customer);
  saveJson('customer', $list);
  exit(http_response_code(200));
}

function getCustomer () {
  // Retrieve customer list.
  $list = getJson('customer');

  // Loop through list and check for queried email.
  foreach ($list as $customer) {
    if ($_GET['id'] == $customer['id']) {
      $customer = new Customer();
      $customer->createFromArray($customer);
      exit($customer->toJson());
    }
  }

  // Otherwise return not found.
  exit(http_response_code(404));
}

function getList () {
  // Retrieve customer list.
  $list = getJson('customer');
  exit(json_encode($list));
}
?>
