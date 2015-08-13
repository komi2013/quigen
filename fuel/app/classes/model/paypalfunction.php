<?php
class Model_PaypalFunction extends \Model
{
  
  //public $PROXY_HOST = '127.0.0.1';
  //public $PROXY_PORT = '808';
  public $SandboxFlag = true;
  public $API_UserName = "komatsuka-facilitator_api1.yahoo.com";
  public $API_Password = "DMYTDA2YFPHFEYTQ"; //profile password is 12345678
  public $API_Signature = "AFcWxV21C7fd0v3bYYYRCpSSRl31AyQJuBHTexT7KPc8sRK6HQBPx51I";
  public $sBNCode = "PP-ECWizard";
  public $API_Endpoint = "https://api-3t.sandbox.paypal.com/nvp";
  public $PAYPAL_URL = "https://www.sandbox.paypal.com/webscr?cmd=_express-checkout&token=";
  public $PAYPAL_DG_URL = "https://www.sandbox.paypal.com/incontext?token=";
  public $USE_PROXY = false;
  public $version = "84";
  function SetExpressCheckoutDG( $paymentAmount, $currencyCodeType, $paymentType, $returnURL, 
                                                                          $cancelURL, $items) 
  {
    $nvpstr = "&PAYMENTREQUEST_0_AMT=". $paymentAmount;
    $nvpstr .= "&PAYMENTREQUEST_0_PAYMENTACTION=" . $paymentType;
    $nvpstr .= "&RETURNURL=" . $returnURL;
    $nvpstr .= "&CANCELURL=" . $cancelURL;
    $nvpstr .= "&PAYMENTREQUEST_0_CURRENCYCODE=" . $currencyCodeType;
    $nvpstr .= "&REQCONFIRMSHIPPING=0";
    $nvpstr .= "&NOSHIPPING=1";

    foreach($items as $index => $item) {

      $nvpstr .= "&L_PAYMENTREQUEST_0_NAME" . $index . "=" . urlencode($item["name"]);
      $nvpstr .= "&L_PAYMENTREQUEST_0_AMT" . $index . "=" . urlencode($item["amt"]);
      $nvpstr .= "&L_PAYMENTREQUEST_0_QTY" . $index . "=" . urlencode($item["qty"]);
      $nvpstr .= "&L_PAYMENTREQUEST_0_ITEMCATEGORY" . $index . "=Digital";
    }
    $resArray = $this->hash_call("SetExpressCheckout", $nvpstr);
    $ack = strtoupper($resArray["ACK"]);
    if($ack == "SUCCESS" || $ack == "SUCCESSWITHWARNING")
    {
      $token = urldecode($resArray["TOKEN"]);
      //$_SESSION['TOKEN'] = $token;
    }

    return $resArray;
  }
  function GetExpressCheckoutDetails( $token )
  {
    $nvpstr="&TOKEN=" . $token;
    $resArray=$this->hash_call("GetExpressCheckoutDetails",$nvpstr);
    $ack = strtoupper($resArray["ACK"]);
      if($ack == "SUCCESS" || $ack=="SUCCESSWITHWARNING")
      {	
        return $resArray;
      } 
      else return false;
  }
  function ConfirmPayment( $token, $paymentType, $currencyCodeType, $payerID, $FinalPaymentAmt, $items )
  {
    $token 				= urlencode($token);
    $paymentType 		= urlencode($paymentType);
    $currencyCodeType 	= urlencode($currencyCodeType);
    $payerID 			= urlencode($payerID);
    $serverName 		= urlencode($_SERVER['SERVER_NAME']);

    $nvpstr  = '&TOKEN=' . $token . '&PAYERID=' . $payerID . '&PAYMENTREQUEST_0_PAYMENTACTION=' . $paymentType . '&PAYMENTREQUEST_0_AMT=' . $FinalPaymentAmt;
    $nvpstr .= '&PAYMENTREQUEST_0_CURRENCYCODE=' . $currencyCodeType . '&IPADDRESS=' . $serverName; 

    foreach($items as $index => $item) {

      $nvpstr .= "&L_PAYMENTREQUEST_0_NAME" . $index . "=" . urlencode($item["name"]);
      $nvpstr .= "&L_PAYMENTREQUEST_0_AMT" . $index . "=" . urlencode($item["amt"]);
      $nvpstr .= "&L_PAYMENTREQUEST_0_QTY" . $index . "=" . urlencode($item["qty"]);
      $nvpstr .= "&L_PAYMENTREQUEST_0_ITEMCATEGORY" . $index . "=Digital";
    }
    $resArray=$this->hash_call("DoExpressCheckoutPayment",$nvpstr);
    $ack = strtoupper($resArray["ACK"]);
    return $resArray;
  }
  function hash_call($methodName,$nvpStr)
  {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL,$this->API_Endpoint);
    curl_setopt($ch, CURLOPT_VERBOSE, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
    curl_setopt($ch, CURLOPT_POST, 1);
    //		if($USE_PROXY)
    //			curl_setopt ($ch, CURLOPT_PROXY, $PROXY_HOST. ":" . $this->PROXY_PORT); 
    $nvpreq="METHOD=" . urlencode($methodName) . "&VERSION=" . urlencode($this->version) . "&PWD=" . urlencode($this->API_Password) . "&USER=" . urlencode($this->API_UserName) . "&SIGNATURE=" . urlencode($this->API_Signature) . $nvpStr . "&BUTTONSOURCE=" . urlencode($this->sBNCode);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $nvpreq);
    $response = curl_exec($ch);
    $nvpResArray=$this->deformatNVP($response);
    $nvpReqArray=$this->deformatNVP($nvpreq);
    //$_SESSION['nvpReqArray']=$nvpReqArray;
    if (curl_errno($ch)) 
    {
      //$_SESSION['curl_error_no']=curl_errno($ch) ;
      //$_SESSION['curl_error_msg']=curl_error($ch);
    } 
    else 
    {
      curl_close($ch);
    }
    return $nvpResArray;
  }
  function RedirectToPayPal ( $token )
  {
    // Redirect to paypal.com here
    $payPalURL = $this->PAYPAL_URL . $token;
    header("Location: ".$payPalURL);
    exit;
  }
  function RedirectToPayPalDG ( $token )
  {
    // Redirect to paypal.com here
    $payPalURL = $this->PAYPAL_DG_URL . $token;
    header("Location: ".$payPalURL);
    exit;
  }
  function deformatNVP($nvpstr)
  {
    $intial=0;
    $nvpArray = array();

    while(strlen($nvpstr))
    {
      //postion of Key
      $keypos= strpos($nvpstr,'=');
      //position of value
      $valuepos = strpos($nvpstr,'&') ? strpos($nvpstr,'&'): strlen($nvpstr);

      /*getting the Key and Value values and storing in a Associative Array*/
      $keyval=substr($nvpstr,$intial,$keypos);
      $valval=substr($nvpstr,$keypos+1,$valuepos-$keypos-1);
      //decoding the respose
      $nvpArray[urldecode($keyval)] =urldecode( $valval);
      $nvpstr=substr($nvpstr,$valuepos+1,strlen($nvpstr));
    }
    return $nvpArray;
  }

}