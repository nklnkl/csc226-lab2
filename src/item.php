<?php
header('Content-type:application/json');
require_once('./json.php');

/*
  routes
*/

switch ($_SERVER['REQUEST_METHOD']) {
  case 'GET':
    get();
    break;
  default:
    http_response_code(405);
    header('Allow: GET');
}

function get () {
  switch ( count($_GET) ) {
    case 0:
      getList();
      break;
    case 1:
      getItem();
      break;
    default:
      //http_response_code(400);
  }
}

/*
  end points
*/
function getItem () {
  $list = getJson('item');
  foreach ($list as $i) {
    if ($_GET['id'] == $i['id']){
      $item = new Item();
      $item->createFromArray($item);
      exit($item->toJson());
    }
  }
  exit(http_response_code(404));
}

function getList () {
  $list = getJson('item');
  exit(json_encode($list));
}
?>
