<?php
class Controller_Quest extends Controller
{

  public function action_index()
  {
    $expires = 3600 * 24;
    header('Last-Modified: Fri Jan 01 2010 00:00:00 GMT');
    header('Expires: ' . gmdate('D, d M Y H:i:s T', time() + $expires));
    header('Cache-Control: private, max-age=' . $expires);
    header('Pragma: ');
    $arr = [
        'quest' => 'クエスト',
        'back to quiz' => 'クイズに戻る',
        'you can get ticket after this time' => '○下記の時間以降に回答チケットをもらえます',
        'or you go to those pages to get ticket' => '○もしくは下記のページにいけば回答チケットをもらえます',
        'answer quiz' => 'クイズに答える',
        'go other quiz' => '他のクイズを確認',
        'go offline' => 'オフラインを確認',
        'go mypage' => 'マイページを確認',
        'go chat' => 'チャットを確認',
        'go rule' => '規約を確認',
        'share quiz' => 'クイズをシェア',
        'comment on quiz' => 'クイズにコメント',
        'make quiz' => 'クイズを作成',
        'or get ticket with point' => '○もしくはポイントで回答チケットをGET',
        'my point' => '所持ポイント',
        ' point' => 'ポイント',
        ' ticket' => 'チケット',
        'buy point' => 'ポイントを購入',
        'you can answer after this time' => '○下記の時間以降に回答できます',
        'answer first' => 'はじめにクイズに答えてください',
        'not enough point' => 'ポイントが足りません',
    ];
    if (Config::get("my.lang") === 'en') {
        $lang = [];
        foreach ($arr as $k => $d) {
           $lang[$k] = $k; 
        }
    } else {
        $lang = $arr;
    }


    $view = View::forge('quest');
    $view->u_id = Model_Cookie::get_usr();
    $view->lang = $lang;
    die($view);
  }

}
