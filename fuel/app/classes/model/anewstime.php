<?php
class Model_ANewsTime extends \Orm\Model
{
  protected static $_properties = array(
    'id',
    'following_u_id',
    'question_id',
    'create_at',
    'q_img',
    'u_img',
    'generator',
  );
  protected static $_table_name = 'a_news_time';

}