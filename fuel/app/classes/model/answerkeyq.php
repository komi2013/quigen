<?php
class Model_AnswerKeyQ extends \Orm\Model
{
  protected static $_properties = array(
    'id',
    'usr_id',
    'question_id',
    'result',
    'create_at',
    'u_img',
  );
  protected static $_table_name = 'answer_key_q';

}