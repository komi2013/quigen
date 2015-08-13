<?php

class Model_Mydata extends \Orm\Model
{
  protected static $_observers = array(
    'Orm\\Observer_CreatedAt' => array('events' => array('before_insert')),
    'Orm\\Observer_UpdatedAt' => array('events' => array('before_save')),
    'Orm\\Observer_Validation' => array('events' => array('before_save')) 
  );

	protected static $_properties = array(
    'usr_id',
    'myphoto' => array(
      'data_type' => 'varchar',
      'default' => '',
    ),
    'myname' => array(
      'data_type' => 'varchar',
      'default' => '',
    ),
    'answer_by_u' => array(
      'data_type' => 'varchar',
      'default' => '',
    ),
    'answer' => array(
      'data_type' => 'varchar',
      'default' => '',
    ),
    'update_at' => array(
      'data_type' => 'varchar',
    ),
	);
	protected static $_table_name = 'mydata';
  protected static $_primary_key = array('usr_id');

}