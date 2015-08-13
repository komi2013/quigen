<?php

class Model_QuizBuy extends \Orm\Model
{
  protected static $_observers = array(
    'Orm\\Observer_CreatedAt' => array('events' => array('before_insert')),
    'Orm\\Observer_UpdatedAt' => array('events' => array('before_save')),
    'Orm\\Observer_Validation' => array('events' => array('before_save')) 
  );

  protected static $_properties = array(
    'id',
    'buyer' => array(
      'data_type' => 'int',
      'default' => 0,
    ),
    'seller' => array(
      'data_type' => 'int',
      'default' => 0,
    ),
    'question_id' => array(
      'data_type' => 'int',
      'default' => 0,
    ),
    'point' => array(
      'data_type' => 'int',
      'default' => 0,
    ),
    'create_at' => array(
      'data_type' => 'varchar',
    ),
  );
  protected static $_table_name = 'quiz_buy';
  public function get_new_id() 
  {
    $res = DB::query("select nextval('quiz_buy_id_seq')")->execute();
    return $res[0]['nextval'];
  }


}