<?php
require_once('../objects/account.php');

class AccountService {
  /*
    This create a valid account with given new user data.
    The account will by default, set at customer level.
    The account will also be assigned a random unique id.

    $data - associative array (required)
      - email
      - password
      - firstName
      - lastName
      - address
      - city
      - state
      - zipcode

    return
      object - (associative array)
        When an object/associative array is returned, this means the account object
        was successfully created (volatile).
      integer
        When an integer is returned, this means that the account is missing data.
        Refer to Account.valid() for an explanation of missing information..
  */
  public static function register ($data) {
    $account = new Account();
    $account->createFromArray($data);
    $account->setLevel(0);
    $account->setId(uniqid());

    if ($account->valid() == 0)
      return $account->toArray();
    else
      return $account->valid();
  }
}
?>
