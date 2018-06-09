<?php

switch($_SERVER['REQUEST_METHOD'])
{
  case 'GET': $the_request = &$_GET;break;
  case 'POST': $the_request = &$_POST;break;
  default: $the_request = array();
}

unset($_id);
if (array_key_exists('_id',$the_request)) {
  $_id=validate_post_data($the_request['_id']);
} else {
  $_id='6100245999979349';
}

?>
