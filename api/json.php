<?php

/*
  All input and output of this module, is strictly associative arrays and json.
  Has no awareness of spec classes.
*/

// Retrieves a json list and returns it as an associative array if id is not specified.
// If the id is specified, it will return one document. If it finds nothing, this returns null.
function getJson ($resource, $id) {
  $json = file_get_contents('./json/' . $resource . '.json');
  $json = json_decode($json, true);

  if ($id === NULL)
    return $json;
  else {
    foreach ($json as $item) {
      if ($item['id'] == $id)
        return $item;
    }
    return NULL;
  }
}

// Retrieves a json list and returns it as an associative array if id is not specified.
// If the id is specified, it will return one document. If it finds nothing, this returns null.
function getNewId ($resource) {
  $json = file_get_contents('./json/' . $resource . '.json');
  $json = json_decode($json, true);

  $highest = 1;
  foreach ($json as $item) {
    if ($item['id'] > $highest)
      $highest = $item['id'] + 1;
  }
  return $highest;
}

// Adds an entry to a json source. $data must have toArray() associative
function saveJson ($resource, $data) {
  // Retrieve json list. associative.
  $json = file_get_contents('./json/' . $resource . '.json');
  $json = json_decode($json, true);

  // Add to list, data must be turned into associative array.
  array_push($json, $data->toArray());

  // Save associative array as json to json file.
  file_put_contents('./json/' . $resource . '.json', json_encode($json));
}

?>
