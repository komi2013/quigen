<?php
class Model_PayComment extends \Orm\Model
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
    'pay_q_id' => array(
      'data_type' => 'int',
      'default' => 0,
    ),
    'create_at' => array(
      'data_type' => 'varchar',
      'default' => '',
    ),
  );
  protected static $_table_name = 'pay_comment';

}