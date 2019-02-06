<?php
class Controller_Translate extends Controller
{
  public function action_index()
  {
    $res[0] = 2;
//    Model_Csrf::check();
    $usr_id = Model_Cookie::get_usr();
    if (!$usr_id) {
      Model_Log::warn('wrong usr');
      die(json_encode($res));
    }

    $key = '07c8bcc481584897aa614043953ca99d';
    $host = "https://api.cognitive.microsofttranslator.com";
    $path = "/translate?api-version=3.0";
    
    $params = "&to=en&to=".$_POST['native'];
    $requestBody = array (
        array (
            'Text' => $_POST['trans_q'],
        ),
    );
    $content = json_encode($requestBody);
    $headers = "Content-type: application/json\r\n" .
        "Content-length: " . strlen($content) . "\r\n" .
        "Ocp-Apim-Subscription-Key: $key\r\n" .
        "X-ClientTraceId: " . $this->com_create_guid() . "\r\n";
    $options = array (
        'http' => array (
            'header' => $headers,
            'method' => 'POST',
            'content' => $content
        )
    );
    $context  = stream_context_create ($options);
    $result = file_get_contents ($host . $path . $params, false, $context);
    $result = json_decode($result,true);

    if ($result[0]['detectedLanguage']['language'] == 'en') {
        $trans_a = $result[0]['translations'][1]['text'];
    } else {
        $trans_a = $result[0]['translations'][0]['text'];        
    }
    $res[0] = 1;
    $res[1] = $trans_a;
    die(json_encode($res));
  }
  function com_create_guid() {
    return sprintf( '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
        mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ),
        mt_rand( 0, 0xffff ),
        mt_rand( 0, 0x0fff ) | 0x4000,
        mt_rand( 0, 0x3fff ) | 0x8000,
        mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff )
    );
  }
}
