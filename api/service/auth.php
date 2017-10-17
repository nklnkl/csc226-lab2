<?php
// Object
require_once('../object/account.php');

// Service
require_once('../json/account.php');

class Auth {

  /*
    This will take a user's provided email and password to provide a session key.
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

    // Create account instance from account data.
    $account = new Account();
    $account->createFromArray($accountData);

    // If the password does not match.
    if ($account->getPassword() != $password)
      return 3;

    // Generate session key.
    $key = uniqid();
    return $key;
  }

  /*
    This will take a user's provided id and session key to find a match to authorize
    a session.

    parameters
      $email *required
      $password *required

    return
      0 - session key is valid
      1 - account list not found, internal server error.
      2 - account not found or invalid key, client error.
      3 - given key does not match, client error.
  */
  public static function authorize ($id, $key) {
    $accountData = AccountJson::get($id);

    // If account list was not found.
    if ($accountData == 1)
      return 1;
    // If account was not found.
    if ($accountData == 2)
      return 2;

    // Create account instance from account data.
    $account = new Account();
    $account->createFromArray($accountData);

    // Retrieve session keys from account.
    $keys = $account->getKeys();
    // Iterate through keys to find matching session key.
    foreach ($keys as $k) {
      // If a match was found.
      if ($k == $key)
        return 0;
    }

    // If a match was never found.
    return 2;
  }
}
?>
