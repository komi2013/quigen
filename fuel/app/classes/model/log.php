<?php
class Model_Log extends \Model
{
  public static function warn($warn='') 
  {
    Log::warning('--start--');
    Log::warning('_SERVER REQUEST_URI '.@$_SERVER['REQUEST_URI']);
    Log::warning('_SERVER REMOTE_ADDR '.@$_SERVER['REMOTE_ADDR']);
    Log::warning('_SERVER REQUEST_METHOD '.@$_SERVER['REQUEST_METHOD']);
    $post = @json_encode($_POST);
    Log::warning('_POST '.substr($post,200));
    Log::warning($warn);
    Log::warning('--end--');
  }
}