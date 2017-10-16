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

  /*
    This will update an account's biographical details.
    Both the $accountData (original) and $updateData (new) must have matching
    ids for the update to take place.

    parameters
      $accountData - associative array (required) * ALL fields required for update.
        - id
        - email
        - password
        - firstName
        - lastName
        - address
        - city
        - state
        - zipcode
        - level
        - keys

      $accountData - associative array (required)
        - id (required)
        - firstName (optional)
        - lastName (optional)
        - address (optional)
        - city (optional)
        - state (optional)
        - zipcode (optional)

    return
      associative array (account) - Succesful update.
      1 - id does not match.
  */
  public static function update ($accountData, $updateData) {
    $account = new Account();
    $account->createFromArray($accountData);
    $update = new Account();
    $update->createFromArray($updateData);

    // Must match id.
    if ($account->getId() != $updateData->getId())
      return 1;

    if ($update->getFirstName() != null) {
      $account->setFirstName( $update->getFirstName() );
    }
    if ($update->getLastName() != null) {
      $account->setLastName( $update->getLastName() );
    }
    if ($update->getAddress() != null) {
      $account->setAddress( $update->getAddress() );
    }
    if ($update->getCity() != null) {
      $account->setCity( $update->getCity() );
    }
    if ($update->getState() != null) {
      $account->setState( $update->getState() );
    }
    if ($update->getZipcode() != null) {
      $account->setZipcode( $update->getZipcode() );
    }

    // Successful update.
    return $account->toArray();
  }
}
?>
