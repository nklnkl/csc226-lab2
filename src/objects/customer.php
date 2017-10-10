<?php
  class Customer {
    // number id
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

    public function valid () {
      if ( $this->getId() === null )
        return false;
      if ( $this->getEmail() === null )
        return false;
      if ( $this->getPassword() === null )
        return false;
      if ( $this->getFirstName() === null )
        return false;
      if ( $this->getLastName() === null )
        return false;
      if ( $this->getAddress() === null )
        return false;
      if ( $this->getCity() === null )
        return false;
      if ( $this->getState() === null )
        return false;
      if ( $this->getZipcode() === null )
        return false;
      if ( $this->getLevel() === null )
        return false;
      return true;
    }

    // Takes an associative array of customer data and creates the class equivalent.
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
