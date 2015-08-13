<?php
class Model_Usr extends \Orm\Model
{
  protected static $_observers = array(
    'Orm\\Observer_CreatedAt' => array('events' => array('before_insert')),
    'Orm\\Observer_UpdatedAt' => array('events' => array('before_save')),
    'Orm\\Observer_Validation' => array('events' => array('before_save')) 
  );

  protected static $_properties = array(
    'id',
    'pv_u_id' => array(
      'data_type' => 'varchar',
//       'validation' => array('required', 'min_length' => array(1), 'max_length' => array(150)),
      'default' => '',
    ),
    'provider' => array(
      'data_type' => 'int',
      'default' => 0,
    ),
    'name' => array(
      'data_type' => 'varchar',
//       'validation' => array('required', 'min_length' => array(1), 'max_length' => array(150)),
      'default' => '',
    ),
    'img' => array(
      'data_type' => 'varchar',
//       'validation' => array('required', 'min_length' => array(1), 'max_length' => array(150)),
      'default' => '',
    ),
    'update_at' => array(
      'data_type' => 'varchar',
    ),
    'introduce' => array(
      'data_type' => 'varchar',
      'default' => '',  
    ),
  );
  protected static $_table_name = 'usr';

  public function get_new_id() 
  {
    $res = DB::query("select nextval('usr_id_seq')")->execute();
    return $res[0]['nextval'];
  }


}