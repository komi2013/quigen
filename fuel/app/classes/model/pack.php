<?php

class Model_Pack extends \Orm\Model
{
  protected static $_observers = array(
    'Orm\\Observer_CreatedAt' => array('events' => array('before_insert')),
    'Orm\\Observer_UpdatedAt' => array('events' => array('before_save')),
    'Orm\\Observer_Validation' => array('events' => array('before_save')) 
  );

  protected static $_properties = array(
    'id',
    'usr_id' => array(
      'data_type' => 'int',
      'default' => 0,
    ),
    'txt' => array(
      'data_type' => 'varchar',
      'validation' => array('required', 'min_length' => array(1), 'max_length' => array(120)),
      'default' => '',
    ),
    'sample_q' => array(
      'data_type' => 'int',
      'default' => 0,
    ),
    'activate' => array(
      'data_type' => 'int',
      'default' => 0,
    ),
    'update_at' => array(
      'data_type' => 'varchar',
      'default' => '',
    ),
  );
  protected static $_table_name = 'pack';

  public function get_new_id() 
  {
    $res = DB::query("select nextval('pack_id_seq')")->execute();
    return $res[0]['nextval'];
  }

}