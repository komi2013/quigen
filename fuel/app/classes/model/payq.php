<?php

class Model_PayQ extends \Orm\Model
{
  protected static $_observers = array(
    'Orm\\Observer_CreatedAt' => array('events' => array('before_insert')),
    'Orm\\Observer_UpdatedAt' => array('events' => array('before_save')),
    'Orm\\Observer_Validation' => array('events' => array('before_save')) 
  );

  protected static $_properties = array(
    'id',
    'pack_id',
    'txt' => array(
      'data_type' => 'varchar',
      'validation' => array('required', 'min_length' => array(1), 'max_length' => array(120)),
      'default' => '',
    ),
    'img' => array(
      'data_type' => 'varchar',
      'default' => '',
    ),
    'create_at' => array(
      'data_type' => 'varchar',
      'default' => '',
    ),
  );
	protected static $_table_name = 'pay_q';

  public function get_new_id() 
  {
    $res = DB::query("select nextval('pay_q_id_seq')")->execute();
    return $res[0]['nextval'];
  }

}