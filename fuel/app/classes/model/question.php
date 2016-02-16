<?php
class Model_Question extends \Orm\Model
{
  protected static $_observers = array(
    'Orm\\Observer_CreatedAt' => array('events' => array('before_insert')),
    'Orm\\Observer_UpdatedAt' => array('events' => array('before_save')),
    'Orm\\Observer_Validation' => array('events' => array('before_save')) 
  );

  protected static $_properties = array(
    'id',
    'txt' => array(
      'data_type' => 'varchar',
      'validation' => array('required', 'min_length' => array(1), 'max_length' => array(1000)),
      'default' => '',
    ),
    'usr_id' => array(
      'data_type' => 'int',
      'default' => 0,
    ),
    'create_at' => array(
      'data_type' => 'varchar',
    ),
    'img' => array(
      'data_type' => 'varchar',
      'default' => '',
    ),
    'open_time' => array(
      'data_type' => 'varchar',
      'validation' => array('required', 'min_length' => array(1), 'max_length' => array(500)),
    ),
  );
  protected static $_table_name = 'question';

  public function get_new_id() 
  {
    $res = DB::query("select nextval('question_id_seq')")->execute();
    return $res[0]['nextval'];
  }

}