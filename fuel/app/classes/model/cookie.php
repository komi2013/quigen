<?php
class Model_Cookie extends \Model
{
  public static function get_usr() 
  {
    $json_arr_u_id = Crypt::decode(Cookie::get('u_id'),Config::get('crypt_key.cookie'));
    $arr_u_id = json_decode($json_arr_u_id);
    if (!isset($arr_u_id[0])) {
      Cookie::delete('u_id');
      //Model_Log::warn('u_id is false');
      return null;
    }
    $query = DB::select()->from('mt_block_hijack')
      ->where('usr_id','=',$arr_u_id[0])
      ->and_where('ymd','>=',$arr_u_id[1])
      ->execute()->as_array();

    if (isset($query[0])) {
      Cookie::delete('u_id');
      Model_Log::warn('u_id is blocked');
      return null;
    }
    return $arr_u_id[0];
  }
  public static function set_usr($u_id) 
  {
    $json_arr_u_id = json_encode(array($u_id,date('ymd')));
    $val = Crypt::encode($json_arr_u_id,Config::get('crypt_key.cookie'));
    Cookie::set('u_id',$val,null,null,null,false,true);
  }

  public static function get($variable) 
  {
    $val = Crypt::decode(Cookie::get($variable),Config::get('crypt_key.cookie'));
    if ($val)
    {
      return $val;
    }
    else
    {
      Cookie::delete($variable);
      Model_Log::warn($variable.' is false');
      return null;
    }
  }
  public static function set($variable,$val) 
  {
    $val = Crypt::encode($val,Config::get('crypt_key.cookie'));
    Cookie::set($variable,$val,null,null,null,false,true);
  }

}