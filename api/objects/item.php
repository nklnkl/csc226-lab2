<?php
	class Item {
		// (string)
		private $name;

		// (string)
		private $id;

		// (float)
		private $price;

		// (int) 0: toy, 1: dry food, 2: wet food
		private $category;

		// (string) Flavor of food, should only really be used with dry or
		// wet food category items.
		private $flavor;

		/* (int)
		 * The type of quantity this item has.
		 * 0: unit, no label
		 * 1: pound
		 * 2: can
		 */
		private $unit;

		function Item ($name, $id, $price, $category, $flavor, $unit) {
			$this->setName($name);
			$this->setId($id);
			$this->setPrice($price);
			$this->setCategory($category);
			$this->setFlavor($flavor);
			$this->setUnit($unit);
		}

		public function getName () {
			return $this->name;
		}
		public function getId () {
			return $this->id;
		}
		public function getPrice () {
			return $this->price;
		}
		public function getCategory () {
			return $this->category;
		}
		public function getFlavor () {
			return $this->flavor;
		}
		public function getUnit () {
			return $this->unit;
		}

		public function setName ($name) {
			$this->name = $name;
		}
		public function setId ($id) {
			$this->id = $id;
		}
		public function setPrice ($price) {
			$this->price = $price;
		}
		public function setCategory ($category) {
			$this->category = $category;
		}
		public function setFlavor ($flavor) {
			$this->flavor = $flavor;
		}
		public function setUnit ($unit) {
			$this->unit = $unit;
		}

		public function getPriceString () {
			return "$" . number_format($this->price, 2);
		}

		public function getCategoryString () {
			switch ($this->category) {
				case 0: return "toy";
				case 1: return "dry food";
				case 2: return "wet food";
				default: return;
			}
		}

		public function getUnitString () {
			switch ($this->category) {
				case 0: return "unit";
				case 1: return "pound";
				case 2: return "can";
				default: return;
			}
		}
	}
?>
