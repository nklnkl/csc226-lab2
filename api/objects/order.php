<?php
	class Order {
		private $id;

		// Should be of type array.
		private $items;

		private $date;

    private $shippingFee = 10;

    private $customer;

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

    public function getCustomer () {
      return $this->customer;
    }

    public function getNewCustomer () {
      return $this->newCustomer;
    }

		public function setId ($id) {
			$this->$id = $id;
		}

		public function setItems ($items) {
			$this->items = items;
		}

		public function setDate ($date) {
			if ($date != null)
				$this->date = $date;
			else
				$this->date = date('H:i, jS F Y');
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

		public function valid () {
			if ( ! isset($this->getId()) )
				return false;
			if ( ! isset($this->getItems()) )
				return false;
			if ( ! isset($this->getDate()) )
				return false;
			if ( ! isset($this->getShippingFee()) )
				return false;
			if ( ! isset($this->getCustomer()) )
				return false;
			if ( ! isset($this->getNewCustomer()) )
				return false;
			return true;
		}

		// Takes an associative array of item data and returns the class equivalent.
		public function createFromArray ($array) {
			$this->setId( $array['id'] );
			$this->setName( $array['items'] );
			$this->setPrice( $array['date'] );
			$this->setCategory( $array['shippingFee'] );
			$this->setFlavor( $array['customer'] );
			$this->setUnit( $array['newCustomer'] );
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
