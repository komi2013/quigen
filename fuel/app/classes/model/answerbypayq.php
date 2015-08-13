<?php

class Model_AnswerByPayQ extends \Orm\Model
{
  protected static $_properties = array(
    'pay_q_id',
    'correct' => array(
      'data_type' => 'int',
      'default' => 0,
    ),
    'amount' => array(
      'data_type' => 'int',
      'default' => 0,
    ),
    'update_at' => array(
      'data_type' => 'varchar',
    ),
	);
  protected static $_table_name = 'answer_by_pay_q';
  protected static $_primary_key = array('pay_q_id');

}