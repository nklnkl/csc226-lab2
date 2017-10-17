<?php
require_once('api/service/account.php');

describe('Account service', function () {

  describe('register', function () {
    $this->data = [];
    $this->data['email'] = 'user@test.com';
    $this->data['password'] = 'testPassword';
    $this->data['firstName'] = 'testFirstName';
    $this->data['lastName'] = 'testLastName';
    $this->data['address'] = '1 Broadway';
    $this->data['city'] = 'new york';
    $this->data['state'] = 'ny';
    $this->data['zipcode'] = '10012';

    $this->registerResult = AccountService::register($this->data);
    it('should return an array', function () {
      $type = gettype($this->registerResult);
      expect($type) -> toEqual('array');
    });
  });

});

?>
