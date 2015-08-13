<?php
class Model_AnswerKeyU extends \Orm\Model
{
  protected static $_properties = array(
    'id',
    'usr_id',
    'question_id',
    'result',
    'create_at',
    'q_txt',
    'q_img',
  );
  protected static $_table_name = 'answer_key_u';

}