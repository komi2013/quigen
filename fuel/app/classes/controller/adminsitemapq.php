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
    
    //センター英語基本,センター英語必須,センター英語重要
    //$arr_question = DB::query("SELECT * FROM question WHERE id in ( select question_id from tag where txt = '".$_GET['txt']."') AND create_at > '2015-10-14 00:00:01' order by open_time desc")->execute()->as_array();
    //$arr_question = DB::query('SELECT * FROM question ORDER BY ID DESC')->execute()->as_array();
    
    
    if ( isset($_GET['url']) ) {
      require_once(APPPATH.'vendor/simple_html_dom.php');
      $html = file_get_html($_GET['url']);
      //echo '<pre>';
      $arr_q = [];
      $arr_a = [];
            
      foreach($html->find('table td') as $k => $d) {
        if ($k % 2 == 1) {
          echo ','.$d->plaintext;
          echo '<br>------------------------<br><br><br><br>';
          $arr_q[] = $d->plaintext;
        } else {
          echo $d->plaintext;
          $arr_a[] = $d->plaintext;
        }
      }
      $arr = [];
      foreach ($arr_a as $k => $d) {
        //DB::query("INSERT INTO word (quiz,answer) VALUES ('".$arr_q[$k]."','".$arr_a[$k]."')")->execute();
      }
      //echo '</pre>';
      die();
    } else {
    
      $sitemap = View::forge('sitemap');
      //$sitemap->param = 'quiz/?q=';
      $sitemap->arr_data = $arr_question;

      $file = DOCROOT.'sitemap/'.$_GET['file'].'.xml';
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