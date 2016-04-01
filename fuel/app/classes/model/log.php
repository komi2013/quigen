<?php
class Model_Log extends \Model
{
  public static function warn($warn='') 
  {
    $warn = @$_SERVER['REMOTE_ADDR']
            .' '.@$_SERVER['REQUEST_METHOD']
            .' '.@$_SERVER['REQUEST_URI']
            .' '.$warn
            .' '.substr( @json_encode($_POST),200 );
    Log::warning($warn);
  }
}