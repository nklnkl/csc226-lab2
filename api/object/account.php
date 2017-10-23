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

    // Takes an associative array of account data and creates the class equivalent.
    public function createFromArray ($array) {
      if (array_key_exists('id', $array))
        $this->setId( $array['id'] );
      if (array_key_exists('email', $array))
        $this->setEmail( $array['email'] );
      if (array_key_exists('password', $array))
        $this->setPassword( $array['password'] );
      if (array_key_exists('firstName', $array))
        $this->setFirstName( $array['firstName'] );
      if (array_key_exists('lastName', $array))
        $this->setLastName( $array['lastName'] );
      if (array_key_exists('address', $array))
        $this->setAddress( $array['address'] );
      if (array_key_exists('city', $array))
        $this->setCity( $array['city'] );
      if (array_key_exists('state', $array))
        $this->setState( $array['state'] );
      if (array_key_exists('zipcode', $array))
        $this->setZipcode( $array['zipcode'] );
      if (array_key_exists('level', $array))
        $this->setLevel( $array['level'] );
      if (array_key_exists('keys', $array))
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
