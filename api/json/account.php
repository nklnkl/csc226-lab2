<?php
// Service
require_once('./json.php');

class AccountJson {

  /*
    This will retrieve a list of accounts stored in the account json resource.

    parameters - none
    return
      array - successfully retrieved list of accounts
      1 - resource list not found, internal server error.
  */
  public static function list () {
    // Retrieve account resources.
    $accounts = Json::get('account', null);

    // If account resource is not avaiable, internal server error.
    if ($accounts == 1)
      return 1;

    // Return accounts.
    return $accounts;
  }

  /*
    This will retrieve an account from the account json resource using an id.

    parameters
      $id - the id of the account. *required
    return
      array - successfully retrieved list of accounts
      1 - resource list not found, internal server error.
      2 - account not found, client error.
  */
  public static function get ($id) {
    // Retrieve account resources.
    $account = Json::get('account', $id);

    // If account resource is not avaiable, internal server error.
    if ($account == 1)
      return 1;
    if ($account == 2)
      return 2;

    // Account found.
    return $account;
  }

  /*
    This will retrieve an account from the account json resource using an email.

    parameters
      $id - the id of the account. *required
    return
      $account - successfully retrieved account.
      1 - resource list not found, internal server error.
      2 - account not found, client error.

  */
  public static function getByEmail ($email) {
    // Retrieve account resources.
    $accounts = Json::save('account', null);

    // If account resource is not avaiable, internal server error.
    if ($list == 1)
      return 1;

    // Iterate through list and return it.
    foreach ($accounts as $account) {
      if ($account['email'] == $email)
        return $account;
    }

    // Account not found.
    return 2;
  }

  /*
    This will save an account to the json storage file.
    The account email must be unique, if not, it will return an error.

    parameters
      $account (Account) - must be complete

    return
      0 - successful save.
      1 - resource not available, internal error.
      2 - account with email already exists, client error.
      2 - account with id already exists, internal error.

  */
  public static function save ($newAccount) {
    // Retrieve account resources.
    $accounts = Json::save('account', null);

    // If account resource is not avaiable, internal server error.
    if ($accounts == 1)
      return 1;

    // Iterate through accounts to check if it already exists
    foreach ($accounts as $account) {
      // It account already exists, return error 1.
      if ($account['email'] == $newAccount['email'])
        return 2;
    }

    // If unique, save it.
    $save = Json::saveJson('account', $newAccount);

    // If id already exists, internal error.
    if ($save == 2)
      return 3;

    return 0;
  }

  /*
    This will update an account to the json storage file.
    The account must exist, if not, it will return an error.

    parameters
      $account (Account) - must be complete

    return
      0 - successful save.
      1 - resource not available, internal error.
      2 - account with id does not exist, client error.
  */
  public static function update ($account) {
    // Retrieve account resources.
    $list = Json::update('account', $account);

    // If resource not found.
    if ($list == 1)
      return 1;
    // If object not found.
    if ($list == 2)
      return 2;

    // If save was successful.
    return 0;
  }
}
?>
