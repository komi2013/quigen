<?php
class Controller_AdminSitemapQ extends Controller
{
  public function action_index()
  {
    require_once(APPPATH.'vendor/simple_html_dom.php');
//    $html = file_get_html($_GET['url']);
    $url = 'https://kids.yahoo.co.jp/zukan/animal/a/a/';
    $next = true;
    $html = file_get_html($url);
    $arr_txt = [];
    $arr_img = [];
    foreach($html->find('p a') as $k => $d) {
//        echo $d->plaintext;
//        echo '<br>------------------------<br><br><br><br>';
        $arr_txt[] = $d->plaintext;
    }
    array_splice($arr_txt, 0, 3);
    array_splice($arr_txt, -1);
    var_dump($arr_txt);
    foreach($html->find('dt a img') as $k => $d) {
        $arr_img[] = $d->src;
    }
    var_dump($arr_img);
    foreach ($arr_txt as $k => $d) {
        $img = file_get_contents($arr_img[$k]);

        file_put_contents('/var/www/picture/public/assets/img/animal/' .$arr_txt[$k].'.jpg', $img);
        echo $arr_txt[$k];
        echo '<br>------------------------<br><br><br><br>';
    }
    echo '<br>------------------------<br><br><br><br>';

    die('koko1made');
    if ( isset($_GET['url']) ) {
      require_once(APPPATH.'vendor/simple_html_dom.php');
      $html = file_get_html($_GET['url']);
      //echo '<pre>';

            
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