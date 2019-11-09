<?php
class Controller_AdminSitemapQ extends Controller
{
  public function action_index()
  {
    require_once(APPPATH.'vendor/simple_html_dom.php');
    $url = 'https://kids.yahoo.co.jp/zukan/animal/a/a/';
    $html = file_get_html($url);
    $next = isset($html->find( '.link_next' )[0]->plaintext);
    $i = 1;
    while ($next) {
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

            file_put_contents('/var/www/picture/public/assets/img/animal/' .$arr_txt[$k].'.jpg', $img);
            DB::query("INSERT INTO 	z_pic_sound (name) VALUES ('".$arr_txt[$k]."')")->execute();
        }
        $i++;
        $url = 'https://kids.yahoo.co.jp/zukan/animal/a/a/index_'.$i.'.html';
        $html = file_get_html($url);
        $next = isset($html->find( '.link_next' )[0]->plaintext);
    }

    die('koko1made');

  }
}