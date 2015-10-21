<?php
class Model_Csrf extends \Orm\Model
{
  protected static $_properties = array(
    'id',
    'token',
    'create_at',
  );
  protected static $_table_name = 'csrf';

  public function get_new_id() 
  {
    $res = DB::query("select nextval('csrf_id_seq')")->execute();
    return $res[0]['nextval'];
  }

  public static function check() 
  {
    $res[0] = 2;
    if ( !isset($_POST['csrf']) )
    {
      $res[1] = 'post csrf is none';
      Model_Log::warn('post csrf is none');
      die(json_encode($res));
    }
    
    $token = Crypt::decode($_POST['csrf'],Config::get('crypt_key.q_data'));
    $token = json_decode($token);
    $usr_id = Model_Cookie::get_usr();
    if ($usr_id != $token[0]) {
      $res[1] = 'usr_id is wrong';
      Model_Log::warn('usr_id is wrong');
      die(json_encode($res));
    }
    $yesterday_now = date('m-d',  strtotime('-1day'));
    if ($yesterday_now > $token[1]) {
      $res[1] = 'time is wrong';
      Model_Log::warn('time is wrong');
      die(json_encode($res));
    }
  }
  public static function setcsrf()
  {
    $csrf_token = [Model_Cookie::get_usr(),date('m-d')];
    $csrf_token = json_encode($csrf_token);
    $csrf_token = Crypt::encode($csrf_token,Config::get('crypt_key.q_data'));
    Cookie::set('csrf',$csrf_token,null,null,null,false,true);
    return $csrf_token;
  }

}