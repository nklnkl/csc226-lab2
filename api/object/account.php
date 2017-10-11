<?php
  class Account {
    // string id
    private $id;
    // string
    private $email;
    // string
    private $password;
    // string
    private $firstName;
    // string
    private $lastName;
    // string
    private $address;
    // string
    private $city;
    // string
    private $state;
    // string
    private $zipcode;
    // number
    private $level; // -1: suspended, 0: customer, 1: admin,
    // session keys (string)
    private $keys = [];

		public function getId () {
			return $this->id;
		}
    public function getEmail () {
      return $this->email;
    }
    public function getPassword () {
      return $this->password;
    }
    public function getFirstName () {
      return $this->firstName;
    }
    public function getLastName () {
      return $this->lastName;
    }
    public function getAddress () {
      return $this->address;
    }
    public function getCity () {
      return $this->city;
    }
    public function getState () {
      return $this->state;
    }
    public function getZipcode () {
      return $this->zipcode;
    }
    public function getLevel () {
      return $this->level;
    }
    public function getKeys () {
      return $this->keys;
    }

		public function setId ($id) {
			$this->id = $id;
		}
    public function setEmail ($email) {
      $this->email = $email;
    }
    public function setPassword ($password) {
      $this->password = $password;
    }
    public function setFirstName ($firstName) {
      $this->firstName = $firstName;
    }
    public function setLastName ($lastName) {
      $this->lastName = $lastName;
    }
    public function setAddress ($address) {
      $this->address = $address;
    }
    public function setCity ($city) {
      $this->city = $city;
    }
    public function setState ($state) {
      $this->state = $state;
    }
    public function setZipcode ($zipcode) {
      $this->zipcode = $zipcode;
    }
    public function setLevel ($level) {
      $this->level = $level;
    }
    public function setKeys ($keys) {
      $this->keys = $keys;
    }

    public function getFullName () {
      return $this->lastName . ", " . $this->firstName;
    }

    public function getFullAddress () {
      return $this->address . ", " . $this->city . " " . $this->state . " " . $this->zipcode;
    }

    public function getLevelString () {
      switch ($this->level) {
        case -1: return 'suspended';
        case 0: return 'customer';
        case 1: return 'admin';
      }
    }

    /*
      Checks if the this account object is valid, meaning not all fields are
      filled out.

      return
        0 - All fields are filled out, valid.
        1 - Missing id.
        2 - Missing email.
        3 - Missing password.
        4 - Missing first name.
        5 - Missing last name.
        6 - Missing address.
        7 - Missing city.
        8 - Missing state.
        9 - Missing zipcode.
        10 - Missing level.
        11 - Missing keys (even empty).
    */
    public function valid () {
      if ( $this->getId() === null )
        return 1;
      if ( $this->getEmail() === null )
        return 2;
      if ( $this->getPassword() === null )
        return 3;
      if ( $this->getFirstName() === null )
        return 4;
      if ( $this->getLastName() === null )
        return 5;
      if ( $this->getAddress() === null )
        return 6;
      if ( $this->getCity() === null )
        return 7;
      if ( $this->getState() === null )
        return 8;
      if ( $this->getZipcode() === null )
        return 9;
      if ( $this->getLevel() === null )
        return 10;
      if ( $this->getKeys() === null )
        return 11;
      return 0;
    }

    // Takes an associative array of account data and creates the class equivalent.
    public function createFromArray ($array) {
      $this->setId( $array['id'] );
      $this->setEmail( $array['email'] );
      $this->setPassword( $array['password'] );
      $this->setFirstName( $array['firstName'] );
      $this->setLastName( $array['lastName'] );
      $this->setAddress( $array['address'] );
      $this->setCity( $array['city'] );
      $this->setState( $array['state'] );
      $this->setZipcode( $array['zipcode'] );
      $this->setLevel( $array['level'] );
      $this->setKeys( $array['keys'] );
    }

    // Returns the object as an associative array.
    public function toArray () {
      return get_object_vars($this);
    }

    // Returns the object as a json string.
    public function toJson () {
      return json_encode(get_object_vars($this));
    }
  }
?>
