<?php
	class Order {
		// number id
		private $id;

		// Should be of type array.
		private $items = [];

		// number (epoch)
		private $date;

		// number, 2 float
    private $shippingFee = 10.00;

		// the id of the customer.
    private $customer;

		// number
		private $newCustomer;

		public function getId () {
			return $this->id;
		}

		public function getItems () {
			return $this->items;
		}

		public function getDate () {
			return $this->date;
		}

		public function getShippingFee () {
			return $this->shippingFee;
		}

    public function getCustomer () {
      return $this->customer;
    }

    public function getNewCustomer () {
      return $this->newCustomer;
    }

		public function setId ($id) {
			$this->id = $id;
		}

		public function setItems ($items) {
			$this->items = $items;
		}

		public function setDate ($date) {
			$this->date = $date;
		}

		public function setShippingFee ($shippingFee) {
			$this->shippingFee = $shippingFee;
		}

    public function setCustomer ($customer) {
      $this->customer = $customer;
    }

    public function setNewCustomer ($newCustomer) {
      $this->newCustomer = $newCustomer;
    }

    public function removeItem ($index) {
      array_splice($this->items, $index, 1);
    }

    public function addItem ($item) {
      array_push($this->items, $item);
    }

    public function clearItems () {
      unset($this->items);
    }

    public function getSubtotal () {
      $total = 0;

      // Loop through each item and add to the sum.
      foreach ($this->items as $item) {
        $total += $item->getPrice();
      }

			// Loop through each item counting each wet food, and adding
			// appropriate discounts.
			$wet = 0;
			foreach ($this->items as $item) {
				if ($item->getCategory() == 2)
					$wet += 1;
			}
			if ($wet <= 5 && $wet >= 10)
				$total -= (0.03 * $wet);
			if ($wet <= 11 && $wet >= 15)
				$total -= (0.04 * $wet);
			if ($wet <= 16)
				$total -= (0.05 * $wet);

      // Add discount based on customer type.
      switch ($this->newCustomer) {
        case 0: // New customer.
          $total -= $total * 0.07;
          break;
        case 1: // Returning customer.
          $total -= $total * 0.05;
          break;
        default:
      }

      // If less than $50, add shipping fee.
      if ($total < 50)
        $total += $this->shippingFee;

      return $total;
    }

    public function getTax () {
      return $this->getSubtotal() * 0.0875;
    }

    public function getTotal () {
      return $this->getSubtotal() + $this->getTax();
    }

		/*
      Checks if the this order object is valid, meaning not all fields are
      filled out.
			0 - All fields are filled out, valid.
			1 - Missing id.
			2 - Missing items.
			3 - Missing date.
			4 - Missing shipping fee.
			5 - Missing customer.
			6 - Missing new customer.
		*/
		public function valid () {
			if ( $this->getId() === null )
				return 1;
			if ( $this->getItems() === null )
				return 2;
			if ( $this->getDate() === null )
				return 3;
			if ( $this->getShippingFee() === null )
				return 4;
			if ( $this->getCustomer() === null )
				return 5;
			if ( $this->getNewCustomer() === null )
				return 6;
			return 0;
		}

		// Takes an associative array of item data and returns the class equivalent.
		public function createFromArray ($array) {
			$this->setId( $array['id'] );
			$this->setItems( $array['items'] );
			$this->setDate( $array['date'] );
			$this->setShippingFee( $array['shippingFee'] );
			$this->setCustomer( $array['customer'] );
			$this->setNewCustomer( $array['newCustomer'] );
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
