<?php
class Model_LgPointTran extends \Orm\Model
{
  protected static $_properties = array(
    'id',
    'usr_id',
    'point',
    'create_at',
    'txt',
  );
  protected static $_table_name = 'lg_point_tran';
}