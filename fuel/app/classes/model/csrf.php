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
    if (!Cookie::get('csrf_id'))
    {
      $res[0] = 2;
      $res[1] = 'csrf id is none';
      Model_Log::warn('csrf id is none');
      die(json_encode($res));
    }
    
    $csrf = Model_Csrf::find('first', array(
      'where' => array(
        array('id', Cookie::get('csrf_id')),
      ),
    ));
    if (!isset($csrf->token))
    {
      $res[0] = 2;
      $res[1] = 'csrf_id is wrong';
      Model_Log::warn('csrf_id is wrong');
      die(json_encode($res));
    }
    if ($csrf->token != $_POST['csrf'])
    {
      $res[0] = 2;
      $res[1] = 'csrf token is wrong';
      Model_Log::warn('csrf token is wrong');
      die(json_encode($res));
    }
    //within 120 minutes, you must post Cookie::get('csrf_id') is already sanitized by upper ORM
    DB::query("delete from csrf where id = ".Cookie::get('csrf_id').
      " OR create_at < "."'".date('Y-m-d H:i:s', time()-(60*120) )."'")->execute();
    $csrf_token = Str::random('alnum', 16);
    Cookie::set('csrf',$csrf_token);

  }
  public static function setcsrf() 
  {
    if (Cookie::get('csrf_id')){
      DB::delete('csrf')->where('id', Cookie::get('csrf_id'))->execute();
    }
    $csrf_token = Str::random('alnum', 16);
    Cookie::set('csrf',$csrf_token);
    $csrf = new Model_Csrf();
    $csrf_id = $csrf->get_new_id();
    $csrf->id = $csrf_id;
    $csrf->token = $csrf_token;
    $csrf->create_at = date('Y-m-d H:i:s');
    $csrf->save();
    Cookie::set('csrf_id',$csrf_id);
  }

}