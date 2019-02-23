<?php
class Controller_PaypalCheckout extends Controller
{
  public function action_index()
  {
    $usr_id = Model_Cookie::get_usr('u_id');
    if (!$usr_id)
    {
      $usr_id = 0;
    }
    Model_Log::warn($usr_id.' try to buy');
    switch ($_POST['yen']){
    case '100':
      $point = '200';
      break;
    case '800':
      $point = '1700';
      break;
    case '1400':
      $point = '3000';
      break;
    default:
      $view = View::forge('404');
      
      die($view);
    }
    $paypal_function = new Model_PaypalFunction();
    /*
      'Paypal_SandboxFlag' => true,
      'Paypal_API_UserName' => 'komatsuka-facilitator_api1.yahoo.com',
      'Paypal_API_Password' => 'DMYTDA2YFPHFEYTQ',
      'Paypal_API_Signature' => 'AFcWxV21C7fd0v3bYYYRCpSSRl31AyQJuBHTexT7KPc8sRK6HQBPx51I',
      'Paypal_API_Endpoint' => 'https://api-3t.sandbox.paypal.com/nvp',
      'PAYPAL_URL' => 'https://www.sandbox.paypal.com/webscr?cmd=_express-checkout&token=',
      'PAYPAL_DG_URL' => 'https://www.sandbox.paypal.com/incontext?token=',
     */
    $paypal_function->SandboxFlag = Config::get('my.Paypal_SandboxFlag');
    $paypal_function->API_UserName = Config::get('my.Paypal_API_UserName');
    $paypal_function->API_Password = Config::get('my.Paypal_API_Password'); //profile password is 12345678
    $paypal_function->API_Signature = Config::get('my.Paypal_API_Signature');
    $paypal_function->API_Endpoint = Config::get('my.Paypal_API_Endpoint');
    $paypal_function->PAYPAL_URL = Config::get('my.PAYPAL_URL');
    $paypal_function->PAYPAL_DG_URL = Config::get('my.PAYPAL_DG_URL');

$PaymentOption = "PayPal";
if ( $PaymentOption == "PayPal")
{
        // ==================================
        // PayPal Express Checkout Module
        // ==================================

	
	        
        //'------------------------------------
        //' The paymentAmount is the total value of 
        //' the purchase.
        //'
        //' TODO: Enter the total Payment Amount within the quotes.
        //' example : $paymentAmount = "15.00";
        //'------------------------------------

        $paymentAmount = $_POST['yen'];
        
        
        //'------------------------------------
        //' The currencyCodeType  
        //' is set to the selections made on the Integration Assistant 
        //'------------------------------------
        $currencyCodeType = "JPY";
        $paymentType = "Sale";

        //'------------------------------------
        //' The returnURL is the location where buyers return to when a
        //' payment has been succesfully authorized.
        //'
        //' This is set to the value entered on the Integration Assistant 
        //'------------------------------------
        $returnURL = "https://".Config::get('my.domain')."/paypalordercomp/";

        //'------------------------------------
        //' The cancelURL is the location buyers are sent to when they hit the
        //' cancel button during authorization of payment during the PayPal flow
        //'
        //' This is set to the value entered on the Integration Assistant 
        //'------------------------------------
        $cancelURL = $_POST['cancel_url'];

        //'------------------------------------
        //' Calls the SetExpressCheckout API call
        //'
        //' The CallSetExpressCheckout function is defined in the file PayPalFunctions.php,
        //' it is included at the top of this file.
        //'-------------------------------------------------

        
		$items = array();
		$items[] = array('name' => $point.' point', 'amt' => $paymentAmount, 'qty' => 1);
	
		//::ITEMS::
		
		// to add anothe item, uncomment the lines below and comment the line above 
		// $items[] = array('name' => 'Item Name1', 'amt' => $itemAmount1, 'qty' => 1);
		// $items[] = array('name' => 'Item Name2', 'amt' => $itemAmount2, 'qty' => 1);
		// $paymentAmount = $itemAmount1 + $itemAmount2;
		
		// assign corresponding item amounts to "$itemAmount1" and "$itemAmount2"
		// NOTE : sum of all the item amounts should be equal to payment  amount 

		$resArray = $paypal_function->SetExpressCheckoutDG( $paymentAmount, $currencyCodeType, $paymentType, 
												$returnURL, $cancelURL, $items );
        $ack = strtoupper($resArray["ACK"]);
        if($ack == "SUCCESS" || $ack == "SUCCESSWITHWARNING")
        {
                $token = urldecode($resArray["TOKEN"]);
                $paypal_function->RedirectToPayPalDG( $token );
        } 
        else  
        {
                //Display a user friendly Error on the page using any of the following error information returned by PayPal
                $ErrorCode = urldecode($resArray["L_ERRORCODE0"]);
                $ErrorShortMsg = urldecode($resArray["L_SHORTMESSAGE0"]);
                $ErrorLongMsg = urldecode($resArray["L_LONGMESSAGE0"]);
                $ErrorSeverityCode = urldecode($resArray["L_SEVERITYCODE0"]);
                
                echo "SetExpressCheckout API call failed. ";
                echo "Detailed Error Message: " . $ErrorLongMsg;
                echo "Short Error Message: " . $ErrorShortMsg;
                echo "Error Code: " . $ErrorCode;
                echo "Error Severity Code: " . $ErrorSeverityCode;
        }
}

  }
}
