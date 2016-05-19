<?php
class Model_Log extends \Model
{
  public static function warn($warn='') 
  {
    $warn = @$_SERVER['REMOTE_ADDR']
            .' '.@$_SERVER['REQUEST_METHOD']
            .' '.substr( @$_SERVER['REQUEST_URI'], 0, 200 )
            .' '.$warn
            .' '.substr( @json_encode($_POST), 0, 200 );
    Log::warning($warn);
  }
}