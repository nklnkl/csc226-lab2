<?php

require_once('../objects/account.php');

class AccountJson {

  /*
    This will save an account to the json storage file.
    The account email must be unique, if not, it will return an error.

    parameters
      $account (Account) - must be complete

    return
      0 - successful save.
      1 - account with email already exists.
  */
  public static function save ($account) {
    // Get list of accounts.
    $list = getJson('account', null);

    // Iterate through accounts to check if it already exists
    foreach($list as $account) {
      // It account already exists, return error 1.
      if ($account['email'] == $account->getEmail())
        return 1;
    }

    // If unique, save it.
    saveJson('account', $account);
    return 0;
  }
}
?>
