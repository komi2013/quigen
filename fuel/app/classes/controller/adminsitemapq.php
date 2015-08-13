<?php
class Controller_AdminSitemapQ extends Controller
{
  public function action_index()
  {
    if ( isset($_GET['mail']) ) {
      //mail("seijirok@gmail.com", "TEST MAIL", "This is a test message.", "From: from@example.com");
      //mb_send_mail("seijirok@gmail.com", "TEST MAIL", "This is a test message.", "From: from@", "-f from@mail.komahana.info" );
      die('mail was sent');
    }
    $usr_id = Model_Cookie::get_usr();
    $auth = false;
    foreach (Config::get('my.adm') as $d)
    {
      if ($d == $usr_id)
      {
        $auth = true;
      }
    }
    if (!$auth AND $_SERVER['REMOTE_ADDR'] != '133.242.146.131')
    {
      $view = View::forge('404');
      
      die($view);
    }
    
    
    if ( isset($_GET['curation']) ) {
      require APPPATH.'vendor/simple_html_dom.php';
      $html = @file_get_html( 'http://novita-study.com/1109/' );
      //$ret = $html->find('table'); 9, 11
      $txt = '';
      foreach ( $html->find( 'table td' ) as $d) {
        if( preg_match('/input/', $d) ){
          $arr_answer = explode('"', $d);
          //var_dump($arr_answer);
          $txt .= $arr_answer[5].'<br>';
        }else{
          $txt .= $d;
        }
        
      }
      $html->clear();
      echo '<pre>';
      var_dump($txt);
      echo '</pre>';
      
      
//      $html = file_get_html( 'http://nihonsimondai.web.fc2.com/sengoseiji.html' );
////      $ret = $html->find( 'p' );
//      $txt = '';
//      foreach ( $html->find( 'p' ) as $d) {
//        $txt .= $d;
//      }
//      $html->clear();
//      //preg_replace($arr_txt, $html, $view);
//      
//      $txt = strip_tags($txt, '<span>');
//      //str_replace($txt, $html, $view)
//      $txt = str_replace('<span onmouseover="this.innerText=', '', $txt);
//      $txt = str_replace(';">答え</span>', '', $txt);
//      echo '<pre>';
//      var_dump($txt);
//      echo '</pre>';
      
      die('curated');
    }
    
    //センター英語基本,センター英語必須,センター英語重要
    $arr_question = DB::query("SELECT * FROM question WHERE id in ( select question_id from tag where txt = 'センター化学') order by id")->execute()->as_array();
    //$arr_question = DB::query('SELECT * FROM question ORDER BY ID DESC')->execute()->as_array();
    
    
    if ( isset($_GET['hatena']) ) {
      $sitemap = View::forge('sitemap');
      
      $arr_q_id = array();
      $asc_q = array();
      foreach ($arr_question as $d) {
        $arr_q_id[] = $d['id'];
        $asc_q[$d['id']]['id'] = $d['id']; 
        $asc_q[$d['id']]['img'] = $d['img']; 
        $asc_q[$d['id']]['txt'] = $d['txt']; 
      }
      $arr_choice = DB::select()->from('choice')
        ->where('question_id','in',$arr_q_id)
        ->execute()->as_array();

      foreach ($arr_choice as $d) {
        $shuffle_choice = array();
        $shuffle_choice[] = $d['choice_0'];
        $shuffle_choice[] = $d['choice_1'];
        $shuffle_choice[] = $d['choice_2'];
        $shuffle_choice[] = $d['choice_3'];
        
        shuffle($shuffle_choice);
        
        $asc_q[$d['question_id']]['choice_0'] = $shuffle_choice[0];
        $asc_q[$d['question_id']]['choice_1'] = $shuffle_choice[1];
        $asc_q[$d['question_id']]['choice_2'] = $shuffle_choice[2];
        $asc_q[$d['question_id']]['choice_3'] = $shuffle_choice[3];
      }
      krsort($asc_q);
      //$arr_choice = DB::query('SELECT * FROM choice WHERE question_id in ('..')')->execute()->as_array();

      $sitemap->asc_q = $asc_q;

      $file = DOCROOT.'sitemap/hatena.html';
      // ファイルをオープンして既存のコンテンツを取得します
      //$current = file_get_contents($file);
      // 新しい人物をファイルに追加します
      //$current = "John Smith\n";
      // 結果をファイルに書き出します
      file_put_contents($file, $sitemap);

      die();
      
    } else {
    
      $sitemap = View::forge('sitemap');
      //$sitemap->param = 'quiz/?q=';
      $sitemap->arr_data = $arr_question;

      $file = DOCROOT.'sitemap/center_chemi_1.xml';
      // ファイルをオープンして既存のコンテンツを取得します
      //$current = file_get_contents($file);
      // 新しい人物をファイルに追加します
      //$current = "John Smith\n";
      // 結果をファイルに書き出します
      file_put_contents($file, $sitemap);

      //die($sitemap);
      //var_dump($res);
      //Log::error('mail was sent');
      die($sitemap);
    }
  }
}