<?php
require_once('api/object/account.php');

describe('Account class', function () {
  $this->id = uniqid();
  $this->email = 'user@test.com';
  $this->password = 'testPassword';
  $this->firstName = 'testFirstName';
  $this->lastName = 'testLastName';
  $this->address = '1 Broadway';
  $this->city = 'new york';
  $this->state = 'ny';
  $this->zipcode = '10012';
  $this->level = 0;

  describe('create from setter methods', function () {
    $this->account = new Account();
    $this->account->setId($this->id);
    $this->account->setEmail($this->email);
    $this->account->setPassword($this->password);
    $this->account->setFirstName($this->firstName);
    $this->account->setLastName($this->lastName);
    $this->account->setAddress($this->address);
    $this->account->setCity($this->city);
    $this->account->setState($this->state);
    $this->account->setZipcode($this->zipcode);
    $this->account->setLevel($this->level);

    it('expects the account object to have matching values', function() {
      expect($this->account->getId()) -> toEqual($this->id);
      expect($this->account->getEmail()) -> toEqual($this->email);
      expect($this->account->getPassword()) -> toEqual($this->password);
      expect($this->account->getFirstName()) -> toEqual($this->firstName);
      expect($this->account->getLastName()) -> toEqual($this->lastName);
      expect($this->account->getAddress()) -> toEqual($this->address);
      expect($this->account->getCity()) -> toEqual($this->city);
      expect($this->account->getState()) -> toEqual($this->state);
      expect($this->account->getZipcode()) -> toEqual($this->zipcode);
      expect($this->account->getLevel()) -> toEqual($this->level);

      expect($this->account->getLevelString()) -> toEqual('customer');
    });

    it('expects the account object -> valid() to return true', function () {
      expect($this->account->valid()) -> toEqual(0);
    });

    it('expects the account object -> toJson to return matching values', function () {
      // Create json string.
      $json = $this->account->toJson();
      // Decode json string into associative array.
      $jsonArray = json_decode($json, true);
      // Set up account object from createArray().
      $this->account->createFromArray($jsonArray);
      // Test values.
      expect($this->account->getId()) -> toEqual($this->id);
      expect($this->account->getEmail()) -> toEqual($this->email);
      expect($this->account->getPassword()) -> toEqual($this->password);
      expect($this->account->getFirstName()) -> toEqual($this->firstName);
      expect($this->account->getLastName()) -> toEqual($this->lastName);
      expect($this->account->getAddress()) -> toEqual($this->address);
      expect($this->account->getCity()) -> toEqual($this->city);
      expect($this->account->getState()) -> toEqual($this->state);
      expect($this->account->getZipcode()) -> toEqual($this->zipcode);
      expect($this->account->getLevel()) -> toEqual($this->level);
    });

    it('expects the account object -> toArray to return matching values', function () {
      $array = $this->account->toArray();
      $this->account->createFromArray($array);
      // Test values.
      expect($this->account->getId()) -> toEqual($this->id);
      expect($this->account->getEmail()) -> toEqual($this->email);
      expect($this->account->getPassword()) -> toEqual($this->password);
      expect($this->account->getFirstName()) -> toEqual($this->firstName);
      expect($this->account->getLastName()) -> toEqual($this->lastName);
      expect($this->account->getAddress()) -> toEqual($this->address);
      expect($this->account->getCity()) -> toEqual($this->city);
      expect($this->account->getState()) -> toEqual($this->state);
      expect($this->account->getZipcode()) -> toEqual($this->zipcode);
      expect($this->account->getLevel()) -> toEqual($this->level);
    });
  });

  describe('create from array', function () {
    $this->array = [];
    $this->array['id'] = $this->id;
    $this->array['email'] = $this->email;
    $this->array['password'] = $this->password;
    $this->array['firstName'] = $this->firstName;
    $this->array['lastName'] = $this->lastName;
    $this->array['address'] = $this->address;
    $this->array['city'] = $this->city;
    $this->array['state'] = $this->state;
    $this->array['zipcode'] = $this->zipcode;
    $this->array['level'] = $this->level;

    $this->account = new Account();
    $this->account->createFromArray($this->array);

    it('expects the account object to have matching values', function () {
      expect($this->account->getId()) -> toEqual($this->id);
      expect($this->account->getEmail()) -> toEqual($this->email);
      expect($this->account->getPassword()) -> toEqual($this->password);
      expect($this->account->getFirstName()) -> toEqual($this->firstName);
      expect($this->account->getLastName()) -> toEqual($this->lastName);
      expect($this->account->getAddress()) -> toEqual($this->address);
      expect($this->account->getCity()) -> toEqual($this->city);
      expect($this->account->getState()) -> toEqual($this->state);
      expect($this->account->getZipcode()) -> toEqual($this->zipcode);
      expect($this->account->getLevel()) -> toEqual($this->level);
    });
  });
});
?>
