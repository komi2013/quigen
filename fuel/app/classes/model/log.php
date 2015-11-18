<?php
class Model_Log extends \Model
{
  public static function warn($warn='') 
  {
    $warn = @$_SERVER['REMOTE_ADDR']
            .' '.@$_SERVER['REQUEST_METHOD']
            .' '.@$_SERVER['REQUEST_URI']
            .' '.@json_encode($_POST)
            .' '.$warn;
    Log::warning($warn);
  }
}