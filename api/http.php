<?php

/*
  This class strictly deals with HTTP requests.
  It has no awareness of object classes and uses primitive types and arrays.
*/

class HTTP {

  public static function respond ($status, $body, $header) {
    http_response_code($status);
    header($header);
    exit(json_encode($body));
  }

  // Retrieves the body of a post request and returns it as an associative array.
  public static function getJsonPost () {
    $raw = file_get_contents("php://input");
    $json = json_decode($raw, true);
    return $json;
  }
}
?>
