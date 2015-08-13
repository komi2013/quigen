<?php

class Model_Correct extends \Orm\Model
{
  protected static $_properties = array(
    'id',
    'question_id',
    'usr_id' => array(
      'data_type' => 'int',
      'default' => 0,
    ),
    'create_at' => array(
      'data_type' => 'varchar',
    ),
  );
  protected static $_table_name = 'correct';

}