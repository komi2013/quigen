<?php
class Model_LgPaypalOrder extends \Orm\Model
{
  protected static $_observers = array(
    'Orm\\Observer_CreatedAt' => array('events' => array('before_insert')),
    'Orm\\Observer_UpdatedAt' => array('events' => array('before_save')),
    'Orm\\Observer_Validation' => array('events' => array('before_save')) 
  );

  protected static $_properties = array(
    'id',
    'usr_id',
    'paypal_transaction_id',
    'create_at',
    'paypal_time',
    'paypal_payer_id',
    'item_name',
  );
  protected static $_table_name = 'lg_paypal_order';

//  public function get_new_id() 
//  {
//    $res = DB::query("select nextval('pay_q_id_seq')")->execute();
//    return $res[0]['nextval'];
//  }

}