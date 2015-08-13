<?php
class Model_MtSnspost extends \Orm\Model
{
  protected static $_properties = array(
    'id',
    'question_id' => array(
      'data_type' => 'int',
      'default' => 0,
    ),
    'tag' => array(
      'data_type' => 'varchar',
      'default' => 0,
    ),
    'create_at' => array(
      'data_type' => 'varchar',
    ),
  );
  protected static $_table_name = 'mt_sns_post';
  protected static $_primary_key = array('id');
}