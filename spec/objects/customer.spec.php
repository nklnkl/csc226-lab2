<?php
require_once('src/objects/customer.php');

describe('Customer class', function () {
  $this->id = 1;
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
    $this->customer = new Customer();
    $this->customer->setId($this->id);
    $this->customer->setEmail($this->email);
    $this->customer->setPassword($this->password);
    $this->customer->setFirstName($this->firstName);
    $this->customer->setLastName($this->lastName);
    $this->customer->setAddress($this->address);
    $this->customer->setCity($this->city);
    $this->customer->setState($this->state);
    $this->customer->setZipcode($this->zipcode);
    $this->customer->setLevel($this->level);

    it('expects the customer object to have matching values', function() {
      expect($this->customer->getId()) -> toBe($this->id);
      expect($this->customer->getEmail()) -> toBe($this->email);
      expect($this->customer->getPassword()) -> toBe($this->password);
      expect($this->customer->getFirstName()) -> toBe($this->firstName);
      expect($this->customer->getLastName()) -> toBe($this->lastName);
      expect($this->customer->getAddress()) -> toBe($this->address);
      expect($this->customer->getCity()) -> toBe($this->city);
      expect($this->customer->getState()) -> toBe($this->state);
      expect($this->customer->getZipcode()) -> toBe($this->zipcode);
      expect($this->customer->getLevel()) -> toBe($this->level);

      expect($this->customer->getLevelString()) -> toBe('customer');
    });

    it('expects the customer object -> valid() to return true', function () {
      expect($this->customer->valid()) -> toEqual(true);
    });

    it('expects the customer object -> toJson to return matching values', function () {
      // Create json string.
      $json = $this->customer->toJson();
      // Decode json string into associative array.
      $jsonArray = json_decode($json, true);
      // Set up customer object from createArray().
      $this->customer->createFromArray($jsonArray);
      // Test values.
      expect($this->customer->getId()) -> toBe($this->id);
      expect($this->customer->getEmail()) -> toBe($this->email);
      expect($this->customer->getPassword()) -> toBe($this->password);
      expect($this->customer->getFirstName()) -> toBe($this->firstName);
      expect($this->customer->getLastName()) -> toBe($this->lastName);
      expect($this->customer->getAddress()) -> toBe($this->address);
      expect($this->customer->getCity()) -> toBe($this->city);
      expect($this->customer->getState()) -> toBe($this->state);
      expect($this->customer->getZipcode()) -> toBe($this->zipcode);
      expect($this->customer->getLevel()) -> toBe($this->level);
    });

    it('expects the customer object -> toArray to return matching values', function () {
      $array = $this->customer->toArray();
      $this->customer->createFromArray($array);
      // Test values.
      expect($this->customer->getId()) -> toBe($this->id);
      expect($this->customer->getEmail()) -> toBe($this->email);
      expect($this->customer->getPassword()) -> toBe($this->password);
      expect($this->customer->getFirstName()) -> toBe($this->firstName);
      expect($this->customer->getLastName()) -> toBe($this->lastName);
      expect($this->customer->getAddress()) -> toBe($this->address);
      expect($this->customer->getCity()) -> toBe($this->city);
      expect($this->customer->getState()) -> toBe($this->state);
      expect($this->customer->getZipcode()) -> toBe($this->zipcode);
      expect($this->customer->getLevel()) -> toBe($this->level);
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

    $this->customer = new Customer();
    $this->customer->createFromArray($this->array);

    it('expects the customer object to have matching values', function () {
      expect($this->customer->getId()) -> toBe($this->id);
      expect($this->customer->getEmail()) -> toBe($this->email);
      expect($this->customer->getPassword()) -> toBe($this->password);
      expect($this->customer->getFirstName()) -> toBe($this->firstName);
      expect($this->customer->getLastName()) -> toBe($this->lastName);
      expect($this->customer->getAddress()) -> toBe($this->address);
      expect($this->customer->getCity()) -> toBe($this->city);
      expect($this->customer->getState()) -> toBe($this->state);
      expect($this->customer->getZipcode()) -> toBe($this->zipcode);
      expect($this->customer->getLevel()) -> toBe($this->level);
    });
  });
});
?>
