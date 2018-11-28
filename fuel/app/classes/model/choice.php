<?php
class Model_Choice extends \Orm\Model
{
  protected static $_observers = array(
    'Orm\\Observer_CreatedAt' => array('events' => array('before_insert')),
    'Orm\\Observer_UpdatedAt' => array('events' => array('before_save')),
    'Orm\\Observer_Validation' => array('events' => array('before_save')) 
  );

  protected static $_properties = array(
    'question_id',
    'choice_0' => array(
      'data_type' => 'varchar',
      'validation' => array('required', 'min_length' => array(1), 'max_length' => array(500)),
      'default' => '',
    ),
    'choice_1' => array(
      'data_type' => 'varchar',
      'validation' => array('min_length' => array(0), 'max_length' => array(500)),
      'default' => '',
    ),
    'choice_2' => array(
      'data_type' => 'varchar',
      'validation' => array('min_length' => array(0), 'max_length' => array(500)),
      'default' => '',
    ),
    'choice_3' => array(
      'data_type' => 'varchar',
      'validation' => array('min_length' => array(0), 'max_length' => array(500)),
      'default' => '',
    ),
    'reference' => array(
      'data_type' => 'varchar',
      'validation' => array( 'max_length' => array(500) ),
      'default' => '',
    ),
  );
  protected static $_table_name = 'choice';
  protected static $_primary_key = array('question_id');


}