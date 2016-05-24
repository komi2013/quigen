<?php
class Controller_AdminSnsPost extends Controller
{
  public function action_index()
  {
    $usr_id = Model_Cookie::get_usr();
    $auth = false;
    foreach (Config::get('my.adm') as $d)
    {
      if ($d == $usr_id)
      {
        $auth = true;
      }
    }
    if (!$auth AND $_SERVER['REMOTE_ADDR'] != '153.126.217.154')
    {
      $view = View::forge('404');
      
      die($view);
    }
    require APPPATH.'vendor/facebook-php-sdk/src/facebook.php';
    require APPPATH.'vendor/tw/twitteroauth/twitteroauth.php';
    //中学歴史 minimum 683 max 1168
    //センター英語基本 minimum 1171, max 1622
    //センター英語必須 minimum 1623, max 2118
    //センター英語重要 minimum 2119, max 2526
    $arr_sns_post = DB::select()->from('mt_sns_post')->where('tag','=',$_GET['tag'])->order_by('question_id', 'desc')->limit(10)->execute()->as_array();
    $post_question_id = $arr_sns_post[0]['question_id'] + 1;
    if ($post_question_id > 1168 AND $_GET['tag'] == '中学歴史') {
      Log::warning('中学歴史 is finished');
      die();  
    } elseif ($post_question_id > 1622 AND $_GET['tag'] == 'センター英語基本') {
      Log::warning('センター英語基本 is finished');
      die();
    } elseif ($post_question_id > 2118 AND $_GET['tag'] == 'センター英語必須') {
      Log::warning('センター英語必須 is finished');
      die();
    } elseif ($post_question_id > 2526 AND $_GET['tag'] == 'センター英語重要') {
      Log::warning('センター英語重要 is finished');
      die();
    }
    
    $client_id = Config::get('my.fb_id');
    $client_secret = Config::get('my.fb_secret');
    
    $facebook = new Facebook(array(
      'appId' =>  $client_id,
      'secret' => $client_secret,
      'cookie' => false,
    ));
    
    
    if ($_GET['tag'] == '中学歴史') {
      $tw_key = 'ANHydy21Zkfvqe1tmHG7grvnp';
      $tw_secret = 'm8sFH0643gd1PvDGDBGaQP04QG0d85BEk9EkkctRa8XO6OpbT9';
      $tw_access = '3141725047-WBETcb4jizHuJj358WQqvQNdbceRAUKgUBtjAiQ';
      $tw_access_secret = 'OCVeP1j7tsaBEY3A9JQGvPas0VT1zrRBQ3YwIYu6mu3IS';
      $token = Config::get('my.fb_access_his');
      $fb_page_id = '1613151385583619';
    } elseif ($_GET['tag'] == 'センター英語基本' OR $_GET['tag'] == 'センター英語必須' OR $_GET['tag'] == 'センター英語重要') {
      $tw_key = 'S04VnlMLxt7Jn0hRhtfzg82LM';
      $tw_secret = 'P4mAkf5ejMMaYOQcXrr0FIDK5PqboTol6vxietYcvBxqDxuM5j';
      $tw_access = '2864849020-1isA1N8WmiW2cfUQFekXNZ5wvwAAtmjazPMshi1';
      $tw_access_secret = 'MRiPs1bkXsYr65odO1rA99OlhQgleJ076hK3k7EwauHoh';
      $token = Config::get('my.fb_access_eng');
      $fb_page_id = '608130099297035';
    } else {
      Log::warning($_GET['tag'].' no tag');
      die();
    }

    $arr_question = DB::select()->from('question')->where('id','=',$post_question_id)->execute()->as_array();

    $q_txt = $arr_question[0]['txt'];
    
    $arr_choice_1 = DB::select()->from('choice')->where('question_id','=',$post_question_id)->execute()->as_array();
    
    $msg = $q_txt.' '.$arr_choice_1[0]['choice_0'].','.$arr_choice_1[0]['choice_1'].','.$arr_choice_1[0]['choice_2'].','.$arr_choice_1[0]['choice_3'];

    $param  = array( 
      'message' => $msg
      ,'link' => 'http://juken.quigen.info/quiz/?q='.$post_question_id
      //,'link' => 'http://juken.quigen.info/?q='.$arr_sns_post[0]['question_id']
      ,'access_token' => $token
    );

    try
    {
      $response =  $facebook->api("/".$fb_page_id."/feed", 'POST', $param);
      echo "<pre>";
      var_dump($response);
      //die();
      $to = new TwitterOAuth($tw_key,$tw_secret,$tw_access,$tw_access_secret);
      $content = 'http://juken.quigen.info/quiz/?q='.$post_question_id.' '.$msg;
      $req = $to->OAuthRequest("https://api.twitter.com/1.1/statuses/update.json","POST",array("status"=>$content));
      $result = json_decode($req);
      
      DB::update('mt_sns_post')->value("question_id",$post_question_id)->where('tag','=',$_GET['tag'])->execute();
      
      
      
      echo 'facebook/twitter';
      //var_dump($result);
      echo "</pre>";
      
      
      
      
      die();
    }
    catch(FacebookApiException $e)
    {
      echo '<pre>';
      var_dump($e);
      echo '</pre>';
      die();
    }
  }
}
