<?php
// Service
require_once('./json.php');

class ItemJson {

  /*
    This will retrieve a list of items stored in the item json resource.

    parameters - none
    return
      array - successfully retrieved list of items
      1 - resource list not found, internal server error.
  */
  public static function list () {
    // Retrieve item resources.
    $items = Json::get('item', null);

    // If item resource is not avaiable, internal server error.
    if ($items == 1)
      return 1;

    // Return items.
    return $items;
  }

  /*
    This will retrieve an item from the item json resource using an id.

    parameters
      $id - the id of the item. *required
    return
      array - successfully retrieved list of items
      1 - resource list not found, internal server error.
      2 - item not found, client error.
  */
  public static function get ($id) {
    // Retrieve item resources.
    $item = Json::get('item', $id);

    // If item resource is not avaiable, internal server error.
    if ($item == 1)
      return 1;
    if ($item == 2)
      return 2;

    // Item found.
    return $item;
  }

  /*
    This will save an item to the json storage file.
    The item email must be unique, if not, it will return an error.

    parameters
      $item (Item) - must be complete

    return
      0 - successful save.
      1 - resource not available, internal error.
      2 - item with email already exists, client error.
      3 - item with id already exists, internal error.

  */
  public static function save ($newItem) {
    // Retrieve item resources.
    $items = Json::get('item', null);

    // If item resource is not avaiable, internal server error.
    if ($items == 1)
      return 1;

    // Iterate through items to check if it already exists
    foreach ($items as $item) {
      // If item name already exists, return error 2.
      if ($item['name'] == $newItem['name'])
        return 2;
    }

    // If unique, save it.
    $save = Json::save('item', $newItem);

    // If id already exists, internal error.
    if ($save == 2)
      return 3;

    return 0;
  }

  /*
    This will update an item to the json storage file.
    The item must exist, if not, it will return an error.

    parameters
      $item (Item) - must be complete

    return
      0 - successful save.
      1 - resource not available, internal error.
      2 - item with id does not exist, client error.
  */
  public static function update ($item) {
    // Retrieve item resources.
    $list = Json::update('item', $item);

    // If resource not found.
    if ($list == 1)
      return 1;
    // If object not found.
    if ($list == 2)
      return 2;

    // If save was successful.
    return 0;
  }
}
?>
