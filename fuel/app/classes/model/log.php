<?php
class Model_Log extends \Model
{
  public static function warn($warn='') 
  {
    $warn = @$_SERVER['REMOTE_ADDR'].' '.@$_SERVER['REQUEST_METHOD'].' '.@$_SERVER['REQUEST_URI'].' '.$warn;
    foreach ($_POST as $k => $d) {
      if ( is_array($d) ) {
        foreach ($d as $kk => $dd) {
          if ( is_array($dd) ) {
            foreach ($dd as $kkk => $ddd) {
              $warn = $warn.' '.$k.' '.$kk.' '.$kkk.' '.$ddd;
            }
          } else {
            $warn = $warn.' '.$k.' '.$kk.' '.$dd;
          }
        }
      } else {
        $warn = $warn.' '.$k.' '.$d;
      }
    }
    Log::warning($warn);
  }
}