<?php
// Object
require_once('../object/account.php');

class Auth {

  /*
    This will take a user's provided password and accountData (pre-queried)
    If the password matches the account, a new session key is added to the account.

    parameters
      $accountData *required
      $password *required

    return
      $account (associative array) - the account with a newly added key.
      1 - given password does not match, client error.
  */
  public static function authenticate ($accountData, $password) {
    // Create account instance from account data.
    $account = new Account();
    $account->createFromArray($accountData);

    // If the password does not match.
    if ($account->getPassword() != $password)
      return 1;

    // Generate session key.
    $key = uniqid();
    // Retrieve keys.
    $keys = $account->getKeys();
    // Add new key to keys.
    array_push($keys, $key);
    // Set new keys.
    $account->setKeys($keys);

    return $account->toArray();
  }

  /*
    This will take a user's provided session key and accountData (pre-queried)
    If the key matches the account, the session key is removed from the account.

    parameters
      $accountData *required
      $key *required

    return
      $account (associative array) - the account with the key removed.
      1 - given key does not match, client error.
  */
  public static function deauthenticate ($accountData, $key) {
    // Create account instance from account data.
    $account = new Account();
    $account->createFromArray($accountData);

    // Retrieve session keys from account.
    $keys = $account->getKeys();
    // Iterate through keys to find matching session key.
    foreach ($keys as $i => $k) {
      // If a match was found.
      if ($k == $key) {
        // Remove key
        array_splice($keys, $i, 1);
        // Set keys.
        $account->setKeys($keys);
        // Return account data.
        return $account->toArray();
      }
    }

    // If a match was never found.
    return 1;
  }

  /*
    This will take a user's provided key and accountData (pre-queried)
    If the key matches the account, the authorization is valid.

    parameters
      $accountData *required
      $key *required

    return
      0 - the authorization is valid.
      1 - given key does not match, client error.
  */
  public static function authorize ($accountData, $key) {
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
    return 1;
  }
}
?>
