<?php
require_once 'vendor/autoload.php';

describe('Account API', function () {

  $this->url = 'http://localhost:8000/api/account.php';

  describe('get list', function () {
    $headers = array('Accept' => 'application/json');
    $options = array();
    $this->request = Requests::get($this->url, $headers, $options);
    it('should return a 200', function () {
      expect($this->request->status_code) -> toEqual(200);
    });
  });

});

?>
