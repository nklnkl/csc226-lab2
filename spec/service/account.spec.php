<?php
require_once('api/service/account.php');

describe('Account service', function () {

  $this->data = [];
  $this->data['email'] = 'user@test.com';
  $this->data['password'] = 'testPassword1';
  $this->data['firstName'] = 'testFirstName';
  $this->data['lastName'] = 'testLastName';
  $this->data['address'] = '1 Broadway';
  $this->data['city'] = 'new york';
  $this->data['state'] = 'ny';
  $this->data['zipcode'] = '10012';

  describe('register', function () {
    $this->result = AccountService::register($this->data);
    it('should return an array', function () {
      $type = gettype($this->result);
      expect($type) -> toEqual('array');

      $passwordMatch = AccountService::verifyPassword($this->data['password'], $this->result['password']);
      expect ($passwordMatch) -> toEqual(true);

      expect ($this->result['firstName']) -> toEqual ($this->data['firstName']);
      expect ($this->result['lastName']) -> toEqual ($this->data['lastName']);
      expect ($this->result['address']) -> toEqual ($this->data['address']);
      expect ($this->result['city']) -> toEqual ($this->data['city']);
      expect ($this->result['state']) -> toEqual ($this->data['state']);
      expect ($this->result['zipcode']) -> toEqual ($this->data['zipcode']);
    });
  });

  describe('update', function () {
    // Register account.
    $this->account = AccountService::register($this->data);
    // Copy account into update.
    $this->update = [];
    // Set changes.
    $this->update['firstName'] = 'testFirstName2';
    $this->update['lastName'] = 'testLastName2';
    $this->update['address'] = '2 Broadway';
    $this->update['city'] = 'yonkers';
    $this->update['state'] = 'nj';
    $this->update['zipcode'] = '10022';

    // Run account update.
    $this->result = AccountService::update($this->account, $this->update);
    it('should return an updated array', function () {
      // Check if result was an updated array.
      $type = gettype($this->result);
      expect($type) -> toEqual('array');

      expect ($this->result['firstName']) -> toEqual ($this->update['firstName']);
      expect ($this->result['lastName']) -> toEqual ($this->update['lastName']);
      expect ($this->result['address']) -> toEqual ($this->update['address']);
      expect ($this->result['city']) -> toEqual ($this->update['city']);
      expect ($this->result['state']) -> toEqual ($this->update['state']);
      expect ($this->result['zipcode']) -> toEqual ($this->update['zipcode']);
    });
  });

  describe('update email', function () {
    // Register account.
    $this->account = AccountService::register($this->data);
    // Set changes.
    $this->email = 'user2@test.com';

    // Run account update.
    $this->result = AccountService::updateEmail($this->account, $this->email);
    it('should return the email', function () {
      // Check if result was an updated array.
      $type = gettype($this->result);
      expect($type) -> toEqual('array');

      // Check if email was updated.
      expect ($this->result['email']) -> toEqual ($this->email);
    });
  });

  describe('update password', function () {
    // Register account.
    $this->account = AccountService::register($this->data);
    // Set changes.
    $this->password = 'password2';

    // Run account password update.
    $this->result = AccountService::updatePassword($this->account, $this->password);

    it('should return the account with an updated password', function () {
      // Check if result was an updated array.
      $type = gettype($this->result);
      expect($type) -> toEqual('array');

      // Get password hash from updated account.
      $this->hash = $this->result['password'];

      // Check if password was updated. Hash stored matches new password.
      $this->match = AccountService::verifyPassword($this->password, $this->hash);
      expect ($this->match) -> toEqual (true);
    });
  });

  describe('verify password', function () {
    $this->password = 'testPassword';
    $this->hash = AccountService::hashPassword($this->password);
    $this->verify = AccountService::verifyPassword($this->password, $this->hash);
    it('should match the given password', function () {
      expect($this->verify) -> toEqual(true);
    });
  });

});

?>
