<?php
// Retrieves the items.json and returns it as a json array.
function getJson ($resource) {
  $json = file_get_contents('./json/' . $resource . '.json');
  $json = json_decode($json, true);
  return $json;
}
?>
