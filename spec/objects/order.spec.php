<?php
require_once('api/object/order.php');
require_once('api/object/item.php');

describe('Order class', function () {

  $this->item1 = new Item();
  $this->item1->setName('Nutro Max Kitten Food, 16 pounds');
  $this->item1->setId(4);
  $this->item1->setPrice(24.50);
  $this->item1->setCategory(1);
  $this->item1->setFlavor('Roasted Chicken');
  $this->item1->setUnit(1);

  $this->item2 = new Item();
  $this->item2->setName('Blue Buffalo, Blue Wilderness Indoor Adult Cat Food, 11 pounds');
  $this->item2->setId(3);
  $this->item2->setPrice(33.99);
  $this->item2->setCategory(1);
  $this->item2->setFlavor('Chicken');
  $this->item2->setUnit(1);

  $this->id = 2;
  $this->items = [];
  array_push($this->items, $this->item1->toArray());
  array_push($this->items, $this->item2->toArray());
  $this->date = 1507593598;
  $this->shippingFee = 10;
  $this->customer = uniqid();;
  $this->newCustomer = 0;

  describe('create from setter methods', function () {
    $this->order = new Order();
    $this->order->setId($this->id);
    $this->order->setItems($this->items);
    $this->order->setDate($this->date);
    $this->order->setShippingFee($this->shippingFee);
    $this->order->setCustomer($this->customer);
    $this->order->setNewCustomer($this->newCustomer);

    it('expects the order object to have matching values', function() {
      expect($this->order->getId()) -> toEqual($this->id);
      expect($this->order->getItems()) -> toEqual($this->items);
      expect($this->order->getDate()) -> toEqual($this->date);
      expect($this->order->getShippingFee()) -> toEqual($this->shippingFee);
      expect($this->order->getCustomer()) -> toEqual($this->customer);
      expect($this->order->getNewCustomer()) -> toEqual($this->newCustomer);

      $items = $this->order->getItems();
    });

    it('expects the order object -> valid() to return true', function () {
      expect($this->order->valid()) -> toEqual(true);
    });

    it('expects the order object -> toJson to return matching values', function () {
      // Create json string.
      $json = $this->order->toJson();
      // Decode json string into associative array.
      $jsonArray = json_decode($json, true);
      // Set up order object from createArray().
      $this->order->createFromArray($jsonArray);
      // Test values.
      expect($this->order->getId()) -> toEqual($this->id);
      expect($this->order->getItems()) -> toEqual($this->items);
      expect($this->order->getDate()) -> toEqual($this->date);
      expect($this->order->getShippingFee()) -> toEqual($this->shippingFee);
      expect($this->order->getCustomer()) -> toEqual($this->customer);
      expect($this->order->getNewCustomer()) -> toEqual($this->newCustomer);

      $items = $this->order->getItems();
    });

    it('expects the order object -> toArray to return matching values', function () {
      $array = $this->order->toArray();
      $this->order->createFromArray($array);
      // Test values.
      expect($this->order->getId()) -> toEqual($this->id);
      expect($this->order->getItems()) -> toEqual($this->items);
      expect($this->order->getDate()) -> toEqual($this->date);
      expect($this->order->getShippingFee()) -> toEqual($this->shippingFee);
      expect($this->order->getCustomer()) -> toEqual($this->customer);
      expect($this->order->getNewCustomer()) -> toEqual($this->newCustomer);

      $items = $this->order->getItems();
    });
  });

  describe('create from array', function () {
    $this->array = [];
    $this->array['id'] = $this->id;
    $this->array['items'] = $this->items;
    $this->array['date'] = $this->date;
    $this->array['shippingFee'] = $this->shippingFee;
    $this->array['customer'] = $this->customer;
    $this->array['newCustomer'] = $this->newCustomer;

    $this->order = new Order();
    $this->order->createFromArray($this->array);

    it('expects the order object to have matching values', function () {
      // Test values.
      expect($this->order->getId()) -> toEqual($this->id);
      expect($this->order->getItems()) -> toEqual($this->items);
      expect($this->order->getDate()) -> toEqual($this->date);
      expect($this->order->getShippingFee()) -> toEqual($this->shippingFee);
      expect($this->order->getCustomer()) -> toEqual($this->customer);
      expect($this->order->getNewCustomer()) -> toEqual($this->newCustomer);

      $items = $this->order->getItems();
    });
  });
});
?>
