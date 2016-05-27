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
  public static function notice($notice='')
  {
    $notice = 'notice - '.date("Y-m-d H:i:s").' --> '
            .@$_SERVER['REMOTE_ADDR']
            .' '.@$_SERVER['REQUEST_METHOD']
            .' '.substr( @$_SERVER['REQUEST_URI'], 0, 200 )
            .' '.$notice
            .' '.substr( @json_encode($_POST), 0, 200 )
            ."\r\n";
    $file = APPPATH.'logs/'.date('Ym').'.php';
    file_put_contents($file, $notice, FILE_APPEND);
  }
}