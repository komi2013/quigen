<?php
class Model_Forum extends \Orm\Model
{
  protected static $_observers = array(
    'Orm\\Observer_CreatedAt' => array('events' => array('before_insert')),
    'Orm\\Observer_UpdatedAt' => array('events' => array('before_save')),
    'Orm\\Observer_Validation' => array('events' => array('before_save')) 
  );

  protected static $_properties = array(
    'id',
    'parent_id' => array(
      'data_type' => 'int',
      'default' => 0,
    ),
    'txt' => array(
      'data_type' => 'varchar',
      'validation' => array('max_length' => array(500)),
      'default' => '',
    ),
    'usr_id' => array(
      'data_type' => 'int',
      'default' => 0,
    ),
    'open_time',
    'u_img',
    'img',
    'nice' => array(
      'data_type' => 'int',
      'default' => 0,
    ),
    'update_at',
  );
  protected static $_table_name = 'forum';

  public function get_new_id() 
  {
    $res = DB::query("select nextval('forum_id_seq')")->execute();
    return $res[0]['nextval'];
  }

}