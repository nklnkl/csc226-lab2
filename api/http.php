<?php

/*
  This module strictly inputs and outputs associative arrays and raw http data.
  Has no awareness of spec classes.
*/

// Retrieves the body of a post request and returns it as an associative array.
function getJsonPost () {
  $raw = file_get_contents("php://input");
  $json = json_decode($raw, true);
  return $json;
}

?>
