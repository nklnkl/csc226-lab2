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
    });
  });

  describe('update', function () {
    // Register account.
    $this->account = AccountService::register($this->data);
    // Copy account into update.
    $this->update = $this->account;
    // Set changes.
    $this->update['firstName'] = 'testFirstName2';
    $this->update['lastName'] = 'testLastName2';
    $this->update['address'] = '2 Broadway';
    $this->update['city'] = 'yonkers';
    $this->update['state'] = 'nj';
    $this->update['zipcode'] = '10022';

    // Run account update.
    $this->result = AccountService::update($this->account, $this->update);
    it('should return an array', function () {
      // Check if result was an array.
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

});

?>
