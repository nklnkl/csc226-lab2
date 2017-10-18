<?php
require_once(dirname(__FILE__) . '/../object/account.php');

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
        When an integer is returned, this means that the account is missing data or invalid.
        Refer to Account.valid() for an explanation of missing information..
  */
  public static function register ($data) {

    // If email is invalid.
    // If the email is invalid.
    if (!self::validateEmail($data['email']))
      return 2;

    // If the password is invalid.
    /*
    currently disabled/failing
    if (self::validatePassword($password) != 0)
      return 3;
    */

    // Set default fields.
    $data['level'] = 0;
    $data['id'] = uniqid();
    $data['keys'] = [];
    // Hash password
    $data['password'] = hash('sha512', $data['password']);

    $account = new Account();
    $account->createFromArray($data);

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

  /*
    This updates the email of an account.

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
      $email - string - the email which the account will be set to.

    return
      $account - update was successful.
      1 - email requested is invalid.
  */
  public static function updateEmail ($accountData, $email) {

    // If the email is invalid.
    if (!self::validateEmail($accountData['email']))
      return 1;

    $account = new Account();
    $account->createFromArray($accountData);
    $account->setEmail($email);
    return $account->toArray();
  }

  /*
    This updates the password of an account.

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
      $password - string - the password which the account will be set to.
        The password must match the following requirements.
          - must be at least 6 characters in length and no more than 12 characters
          - must contain at least 1 regular character.
          - must contain at least 1 number.

    return
      $account - update was successful.
      1 - password too short.
      2 - password too long.
      3 - password does not contain at least 1 regular character.
      4 - password does not contain at least 1 number.
  */
  public static function updatePassword ($accountData, $password) {

    $validate = self::validatePassword($password);
    if ($validate != 0)
      return validate;

    $account = new Account();
    $account->createFromArray($accountData);
    $account->setPassword(self::hashPassword($password));
    return $account->toArray();
  }

  /*
    This updates the level of an account.

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
      $level - integer - the level which the account will be set to.

    return
      $account - update was successful.
      1 - level requested is invalid.
  */
  public static function updateLevel ($accountData, $level) {

    // If the level requested is either less than -1 or greater than 1.
    if ($level < -1 || $level > 1)
      return 1;

    $account = new Account();
    $account->createFromArray($accountData);
    $account->setLevel($level);
    return $account->toArray();
  }

  /*
    This validates an email address.

    return
      true - valid email format
      false - invalid email format
  */
  public static function validateEmail ($email) {
    if (filter_var($email, FILTER_VALIDATE_EMAIL))
      return true;
    else
      return false;
  }

  /*
    This validates a password.

    return
      0 - password is valid
      1 - password is too short
      2 - password is too long
      3 - password does not contain at least 1 character
      4 - password does not contain at least 1 digit
  */
  public static function validatePassword ($password) {
    // Validate password length.
    if ( strlen($password) < 6 )
      return 1;
    // Validate password length.
    if ( strlen($password) > 32 )
      return 2;
    // Validate password, contains at least 1 character
    if ( preg_match('/[a-zA-Z]/', $password) === 0)
      return 3;
    // Validate password, contains at least 1 digit
    if ( preg_match('/\d/', $password) === 0)
      return 4;
    return 0;
  }

  public static function hashPassword ($password) {
    return password_hash($password, PASSWORD_BCRYPT);
  }

  public static function verifyPassword ($password, $hash) {
    return password_verify($password, $hash);
  }
}
?>
