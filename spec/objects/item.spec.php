<?php
require_once('api/object/item.php');

describe('Item class', function () {

	// (number)
	$this->id = 1;
	// (string)
	$this->name = 'testName';
	// (float)
	$this->price = 2.99;
	// (int) 0: toy, 1: dry food, 2: wet food
	$this->category = 1;
	// (string) Flavor of food, should only really be used with dry or
	// wet food category items.
	$this->flavor = 'chicken';
  $this->unit = 1;

  describe('create from setter methods', function () {
    $this->item = new Item();
    $this->item->setId($this->id);
    $this->item->setName($this->name);
    $this->item->setPrice($this->price);
    $this->item->setCategory($this->category);
    $this->item->setFlavor($this->flavor);
    $this->item->setUnit($this->unit);

    it('expects the item object to have matching values', function() {
      expect($this->item->getId()) -> toEqual($this->id);
      expect($this->item->getName()) -> toEqual($this->name);
      expect($this->item->getPrice()) -> toEqual($this->price);
      expect($this->item->getCategory()) -> toEqual($this->category);
      expect($this->item->getFlavor()) -> toEqual($this->flavor);
      expect($this->item->getUnit()) -> toEqual($this->unit);

      expect($this->item->getPriceString()) -> toEqual('$2.99');
      expect($this->item->getCategoryString()) -> toEqual('dry food');
      expect($this->item->getUnitString()) -> toEqual('pound');
    });

    it('expects the item object -> valid() to return true', function () {
      expect($this->item->valid()) -> toEqual(0);
    });

    it('expects the item object -> toJson to return matching values', function () {
      // Create json string.
      $json = $this->item->toJson();
      // Decode json string into associative array.
      $jsonArray = json_decode($json, true);
      // Set up item object from createArray().
      $this->item->createFromArray($jsonArray);
      // Test values.
      expect($this->item->getId()) -> toEqual($this->id);
      expect($this->item->getName()) -> toEqual($this->name);
      expect($this->item->getPrice()) -> toEqual($this->price);
      expect($this->item->getCategory()) -> toEqual($this->category);
      expect($this->item->getFlavor()) -> toEqual($this->flavor);
      expect($this->item->getUnit()) -> toEqual($this->unit);

      expect($this->item->getPriceString()) -> toEqual('$2.99');
      expect($this->item->getCategoryString()) -> toEqual('dry food');
      expect($this->item->getUnitString()) -> toEqual('pound');
    });

    it('expects the item object -> toArray to return matching values', function () {
      $array = $this->item->toArray();
      $this->item->createFromArray($array);
      // Test values.
      // Test values.
      expect($this->item->getId()) -> toEqual($this->id);
      expect($this->item->getName()) -> toEqual($this->name);
      expect($this->item->getPrice()) -> toEqual($this->price);
      expect($this->item->getCategory()) -> toEqual($this->category);
      expect($this->item->getFlavor()) -> toEqual($this->flavor);
      expect($this->item->getUnit()) -> toEqual($this->unit);

      expect($this->item->getPriceString()) -> toEqual('$2.99');
      expect($this->item->getCategoryString()) -> toEqual('dry food');
      expect($this->item->getUnitString()) -> toEqual('pound');
    });
  });

  describe('create from array', function () {
    $this->array = [];
    $this->array['id'] = $this->id;
    $this->array['name'] = $this->name;
    $this->array['price'] = $this->price;
    $this->array['category'] = $this->category;
    $this->array['flavor'] = $this->flavor;
    $this->array['unit'] = $this->unit;

    $this->item = new Item();
    $this->item->createFromArray($this->array);

    it('expects the item object to have matching values', function () {
      // Test values.
      expect($this->item->getId()) -> toEqual($this->id);
      expect($this->item->getName()) -> toEqual($this->name);
      expect($this->item->getPrice()) -> toEqual($this->price);
      expect($this->item->getCategory()) -> toEqual($this->category);
      expect($this->item->getFlavor()) -> toEqual($this->flavor);
      expect($this->item->getUnit()) -> toEqual($this->unit);

      expect($this->item->getPriceString()) -> toEqual('$2.99');
      expect($this->item->getCategoryString()) -> toEqual('dry food');
      expect($this->item->getUnitString()) -> toEqual('pound');
    });
  });
});
?>
