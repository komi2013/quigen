<?php

class Model_PayAnswerednews extends \Orm\Model
{

  protected static $_properties = array(
    'id',
    'usr_id',
    'summary',
    'update_at',
    'pay_q_id',
    'q_txt',
    'q_img',
  );
  protected static $_table_name = 'pay_answered_news';

}