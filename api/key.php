<?php
header('Content-type:application/json');
require_once('./json.php');
require_once('./http.php');
require_once('./objects/customer.php');

/*
  routes
*/

switch ($_SERVER['REQUEST_METHOD']) {
  case 'POST';
    post();
    break;
  default:
    http_response_code(405);
    header('Allow: POST');
}

/*
  end points
*/

function post () {
  $data = getJsonPost();

  // Check if credentials match any user..
  $list = getJson('customer', null);
  foreach($list as $i) {
    // Create customer object from current iteration.
    $customer = new Customer();
    $customer->createFromArray($i);
    // Check for email match.
    $emailMatch = ($customer->getEmail() == $data['email']);
    // Check for password match.
    $passwordMatch = ($customer->getPassword() == $data['password']);
    // Check for email and password match.
    $match = ($emailMatch && $passwordMatch);
    // If it does match,
    if ($match) {
          // Create a unique string.
          $key = uniqid();
          // Retrieve the keys array from the customer.
          $keys = $customer->getKeys();
          // Push the new unique string/key into the keys array.
          array_push($keys, $key);
          // Set the new keys array into the customer.
          $customer->setKeys($keys);
          // Save the customer back to the json.
          saveJson('customer', $customer->toArray());
          // Return back with the new keys and user id.
          $response = [];
          $response['id'] = $customer->getId();
          $response['key'] = $key;
          exit(json_encode($response));
    }
  }
  // If there's no credential match.
  exit(http_response_code(404));
}
?>
