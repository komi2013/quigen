<?php
class Controller_AdminSitemapQ extends Controller
{
  public function action_index()
  {
    if (isset($_GET['api'])) {
        // you need to get 586 mp3,  
        $arr = DB::query("select * from z_pic_sound where big_category = 'animal' and id >= 221 and small_category = 'mammals' and representative is not null"
                . " order by small_category, id ")->execute()->as_array();
        foreach ($arr as $d) {
            echo '<div class="object">'.$d['representative'].'</div>';
        }
    }

    die('api is done');
    $arr = DB::query("select * from z_pic_sound where big_category = '".$_GET['api']."' order by small_category, id ")->execute()->as_array();
    foreach ($arr as $d) {
        echo '<div class="object">'.$d['name'].'<img style="max-width:50px;" src="/assets/img/animal/'.$d['name'].'.jpg">'.'</div>';
    }
    
    die('showed picture and name');

//https://kids.yahoo.co.jp/zukan/plant/season/spring/
//    https://kids.yahoo.co.jp/zukan/plant/season/summer/

    require_once(APPPATH.'vendor/simple_html_dom.php');
    $url = $url1 = 'https://kids.yahoo.co.jp/zukan/job/like/life_society/';
    $i = 1;
    $next = true;
    while ($next) {
        $html = file_get_html($url);
        $next = isset($html->find( '.link_next' )[0]->plaintext);
        $arr_txt = [];
        $arr_img = [];
        foreach($html->find('p a') as $k => $d) {
            $arr_txt[] = $d->plaintext;
        }
        array_splice($arr_txt, 0, 3);
        array_splice($arr_txt, -1);
        foreach($html->find('dt a img') as $k => $d) {
            $arr_img[] = $d->src;
        }
        foreach ($arr_txt as $k => $d) {
            $img = file_get_contents($arr_img[$k]);

            file_put_contents('/var/www/picture/public/assets/img/job/' .$arr_txt[$k].'.jpg', $img);
            DB::query("INSERT INTO z_pic_sound (name,big_category,small_category) VALUES ('".$arr_txt[$k]."','job','life_society')")->execute();
        }
        $i++;
        $url = $url1.'index_'.$i.'.html';
//        $html = file_get_html($url);
//        $next = isset($html->find( '.link_next' )[0]->plaintext);
    }

    die('koko1made');

  }
}