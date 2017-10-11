<?php
/*
  All input and output of this class, is strictly associative arrays and json.
  Has no awareness of spec classes.
*/

class Json {
  private static function retriveJson ($resource) {
    $json = file_get_contents('../json/' . $resource . '.json');
    $array = json_decode($json, true);
    return $array;
  }

  // Retrieves a json list and returns it as an associative array if id is not specified.
  // If the id is specified, it will return one document. If it finds nothing, this returns null.
  public static function get ($resource, $id) {
    $array = self::retriveJson($resource);

    if ($id === NULL)
      return $array;
    else {
      foreach ($array as $item) {
        if ($item['id'] == $id)
          return $item;
      }
      return NULL;
    }
  }

  // Adds an entry to a json source. $data must have toArray() associative
  public static function save ($resource, $data) {
    $array = self::retriveJson($resource);

    // Check if data already has a record
    foreach($array as $i => $doc) {
      // If it does, do a replacement instead.
      if ($doc['id'] == $data['id']) {
        $json[$i] = $data;
        // Save associative array as json to json file.
        file_put_contents('../json/' . $resource . '.json', json_encode($json, JSON_PRETTY_PRINT|JSON_NUMERIC_CHECK));
        return;
      }
    }

    // If there is no record, add to list, data must be turned into associative array.
    // It must also have a uniqueid.
    $data['id'] = uniqid();
    array_push($json, $data);
    // Save associative array as json to json file.
    file_put_contents('../json/' . $resource . '.json', json_encode($json, JSON_PRETTY_PRINT|JSON_NUMERIC_CHECK));
    return;
  }

  // Adds an entry to a json source. $data must have toArray() associative
  public static function update ($resource, $data) {
    $array = self::retriveJson($resource);

    // Check if data already has a record
    foreach($json as $i => $doc) {
      // If it does, do a replacement instead.
      if ($doc['id'] == $data['id']) {
        $json[$i] = $data;
        // Save associative array as json to json file.
        file_put_contents('../json/' . $resource . '.json', json_encode($json, JSON_PRETTY_PRINT|JSON_NUMERIC_CHECK));
        return;
      }
    }

    // If there is no record, add to list, data must be turned into associative array.
    // It must also have a uniqueid.
    $data['id'] = uniqid();
    array_push($json, $data);
    // Save associative array as json to json file.
    file_put_contents('../json/' . $resource . '.json', json_encode($json, JSON_PRETTY_PRINT|JSON_NUMERIC_CHECK));
    return;
  }
}

?>
