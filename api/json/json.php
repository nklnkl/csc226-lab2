<?php
/*
  All input and output of this class, is strictly associative arrays and json.
  Has no awareness of spec classes.
*/

class Json {
  /*
    Retrieves a resource from the json directory.

    parameters
      $resource - name of the resource [account, item, order]
    return
      $array - array list of given resource
      1 - resource list not available.
  */
  private static function retriveJson ($resource) {
    $json = file_get_contents('../json/' . $resource . '.json');

    if ($json == false)
      return 1;

    $list = json_decode($json, true);
    return $list;
  }

  /*
    Retrieves a resource list or resource object.
    If given the id of the resource object, it will query for that object.

    parameters
      $resource - name of the resource [account, item, order]
      $id - the id of the resource object. this is optional.

    return
      $array - a resource list is found and is being returned.
      1 - resource list not found.
  */
  public static function get ($resource, $id) {
    // Retrieve resource.
    $list = self::retriveJson($resource);
    // If resource is not availabe.
    if ($list == 1) return 1;

    // If no id is given, return list.
    if ($id === NULL)
      return $list;
    // Else if id is given.
    else {
      // Iterate through list and return it.
      foreach ($list as $object) {
        if ($object['id'] == $id)
          return $object;
      }
      // If not found.
      return 2;
    }
  }

  /*
    Takes an array (associative object) and saves it to a particular resource.
    This is for new data only.

    parameters
      $resource - name of the resource [account, item, order]
      $data - associative array, must have a key for 'id' which must be unique.

    return
      0 - save was succcessful
      1 - resource list not found.
      2 - failed, object with id already exists.
  */
  public static function save ($resource, $data) {
    // Retrieve resource.
    $list = self::retriveJson($resource);
    // If resource is not availabe.
    if ($list == 1) return 1;

    // Iterate through list.
    foreach($list as $i => $object) {
      // If object with id already exists.
      if ($object['id'] == $data['id'])
        return 1;
    }

    // If there is no record, add to list
    array_push($list, $data);
    // Save associative array as json to json file.
    file_put_contents('../json/' . $resource . '.json', json_encode($list, JSON_PRETTY_PRINT|JSON_NUMERIC_CHECK));
    return;
  }

  /*
    Takes an array (associative object) and saves it to a particular resource.
    This is for new data only.

    parameters
      $resource - name of the resource [account, item, order]
      $data - associative array, must have a key for 'id' which must be unique.

    return
      0 - save was succcessful
      1 - resource list not found.
      2 - failed, object with id does not exist.
  */
  public static function update ($resource, $data) {
    // Retrieve resource.
    $list = self::retriveJson($resource);
    // If resource is not availabe.
    if ($list == 1) return 1;

    // Iterate through list.
    foreach($list as $i => $list) {
      // If an object with the given id exists, update the doc. (replace it)
      if ($list['id'] == $data['id']) {
        $list[$i] = $data;
        // Save back list.
        file_put_contents('../json/' . $resource . '.json', json_encode($list, JSON_PRETTY_PRINT|JSON_NUMERIC_CHECK));
        return 0;
      }
    }

    // If object does not exists.
    return 2;
  }

  /*
    Takes an array (associative object) and removes it.
    This is for existing data only.

    parameters
      $resource - name of the resource [account, item, order]
      $data - associative array, must have a key for 'id' which must be unique.

    return
      0 - save was succcessful
      1 - resource list not found.
      2 - failed, object with id does not exist.
  */
  public static function remove ($resource, $data) {
    // Retrieve resource.
    $list = self::retriveJson($resource);
    // If resource is not availabe.
    if ($list == 1) return 1;

    // Iterate through list.
    foreach($list as $i => $object) {
      // If an object with the given id exists, remove it.
      if ($object['id'] == $data['id']) {
        array_splice($list, $i, 1);
        return 0;
      }
    }

    // If object does not exists.
    return 2;
  }
}

?>
