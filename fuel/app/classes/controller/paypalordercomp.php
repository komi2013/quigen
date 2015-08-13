<?php
class Controller_PaypalOrdercomp extends Controller
{
  public function action_index()
  {
    $paypal_function = new Model_PaypalFunction();
    $res = $paypal_function->GetExpressCheckoutDetails( $_REQUEST['token'] );
    $finalPaymentAmount =  $res["PAYMENTREQUEST_0_AMT"];
    $token 				= $_REQUEST['token'];
    $payerID 			= $_REQUEST['PayerID'];
    $paymentType 		= 'Sale';
    $currencyCodeType 	= $res['CURRENCYCODE'];
    $items = array();
    $i = 0;
    while(isset($res["L_PAYMENTREQUEST_0_NAME$i"]))
    {

      $items[] = array('name' => $res["L_PAYMENTREQUEST_0_NAME$i"], 'amt' => $res["L_PAYMENTREQUEST_0_AMT$i"], 'qty' => $res["L_PAYMENTREQUEST_0_QTY$i"]);
      $i++;
    }
    $resArray = $paypal_function->ConfirmPayment ( $token, $paymentType, $currencyCodeType, $payerID, $finalPaymentAmount, $items );
    $ack = strtoupper($resArray["ACK"]);
    if( $ack == "SUCCESS" || $ack == "SUCCESSWITHWARNING" )
    {
      $transactionId		= $resArray["PAYMENTINFO_0_TRANSACTIONID"]; // Unique transaction ID of the payment.
      $transactionType 	= $resArray["PAYMENTINFO_0_TRANSACTIONTYPE"]; // The type of transaction Possible values: l  cart l  express-checkout
      $paymentType		= $resArray["PAYMENTINFO_0_PAYMENTTYPE"];  // Indicates whether the payment is instant or delayed. Possible values: l  none l  echeck l  instant
      $orderTime 			= $resArray["PAYMENTINFO_0_ORDERTIME"];  // Time/date stamp of payment
      $amt				= $resArray["PAYMENTINFO_0_AMT"];  // The final amount charged, including any  taxes from your Merchant Profile.
      $currencyCode		= $resArray["PAYMENTINFO_0_CURRENCYCODE"];  // A three-character currency code for one of the currencies listed in PayPay-Supported Transactional Currencies. Default: USD.
      $feeAmt				= $resArray["PAYMENTINFO_0_FEEAMT"];  // PayPal fee amount charged for the transaction
  //	$settleAmt			= $resArray["PAYMENTINFO_0_SETTLEAMT"];  // Amount deposited in your PayPal account after a currency conversion.
      $taxAmt				= $resArray["PAYMENTINFO_0_TAXAMT"];  // Tax charged on the transaction.
  //	$exchangeRate		= $resArray["PAYMENTINFO_0_EXCHANGERATE"];  // Exchange rate if a currency conversion occurred. Relevant only if your are billing in their non-primary currency. If the customer chooses to pay with a currency other than the non-primary currency, the conversion occurs in the customer's account.
      $paymentStatus = $resArray["PAYMENTINFO_0_PAYMENTSTATUS"];
      $pendingReason = $resArray["PAYMENTINFO_0_PENDINGREASON"];
      $reasonCode	= $resArray["PAYMENTINFO_0_REASONCODE"];
      
      $usr_id = Model_Cookie::get_usr();
      switch ($items[0]["name"]) {
        case '200 point':
          $point = 200;
          break;
        case '1700 point':
          $point = 1700;
          break;
        case '3000 point':
          $point = 3000;
          break;
      }
      
      try
      {
        DB::start_transaction();
        DB::query("update usr set point = point + ".$point." where id = ".$usr_id)->execute();

        $lg_paypal_order = new Model_LgPaypalOrder();
        $lg_paypal_order->usr_id = $usr_id;
        $lg_paypal_order->paypal_transaction_id = $transactionId;
        $lg_paypal_order->create_at = date('Y-m-d H:i:s');
        $lg_paypal_order->paypal_time = $orderTime;
        $lg_paypal_order->paypal_payer_id = $payerID;
        $lg_paypal_order->item_name = $items[0]["name"];
        $lg_paypal_order->save();
        DB::commit_transaction();
      }
      catch (Orm\ValidationFailed $e)
      {
        DB::rollback_transaction();
        $res = $e->getMessage();
        $view = View::forge('500');
        
        die($view);
      }
    }
    else
    {
      //Display a user friendly Error on the page using any of the following error information returned by PayPal
      $ErrorCode = urldecode($resArray["L_ERRORCODE0"]);
      $ErrorShortMsg = urldecode($resArray["L_SHORTMESSAGE0"]);
      $ErrorLongMsg = urldecode($resArray["L_LONGMESSAGE0"]);
      $ErrorSeverityCode = urldecode($resArray["L_SEVERITYCODE0"]);
      $paypal_transaction_err = ""
      ."DoExpressCheckoutDetails API call failed. "
      ."Detailed Error Message: " . $ErrorLongMsg
      ."Short Error Message: " . $ErrorShortMsg
      ."Error Code: " . $ErrorCode
      ."Error Severity Code: " . $ErrorSeverityCode
      ;
      Log::error($paypal_transaction_err);
      die();
    }
    Cookie::set('add_point', $point);
    Response::redirect('/paid/');
  }
}
