<?php
// Object
require_once('../object/account.php');

// Service
require_once('../json/account.php');

class Auth {

  /*
    This will take a user's given email and password to provide a session key.
    If the email and password find a match, a session key is returned.

    parameters
      $email *required
      $password *required

    return
      string - the session key which can be used for future authorization.
      1 - account list not found, internal server error.
      2 - account not found, client error.
      3 - given password does not match, client error.
  */
  public static function authenticate ($email, $password) {
    $accountData = AccountJson::getByEmail($email);

    // If the account list was not found.
    if ($accountData == 1)
      return 1;
    // If the account was not found.
    if ($accountData == 2)
      return 2;

    $account = new Account();
    $account->createFromArray($accountData);

    // If the password does not match.
    if ($account->getPassword() != $password)
      return 3;

    // Generate session key.
    $key = uniqid();
    return $key;
  }

  public static function authorize () {
  }
}
?>
