<?php
class Controller_Newsshow extends Controller
{
  public function action_index()
  {
    $res[0] = 2;
    $usr_id = Model_Cookie::get_usr();
    if (!$usr_id) {
      die(json_encode($res));
    }    
    $comma_q_id = '0';
    foreach ($_GET['arr_myanswer_id'] as $k => $d) {
      $comma_q_id .= ','.$d;
    }
    $comma_following_u_id = '0';
    if ( isset($_GET['follow']) ) {
      foreach ($_GET['follow'] as $k => $d) {
        $comma_following_u_id .= ','.$d;
      }
    }
    $arr_a_news = DB::query("select * from a_news_time where ( question_id in ("
      .$comma_q_id.") or following_u_id in ("
      .$comma_following_u_id.") or generator = ".$usr_id." ) "
      ." and following_u_id <> ".$usr_id
      ." and create_at > '".date('Y-m-d H:i:s',$_GET['last_checked'] * 60 * 60)."'"
      ." limit 20")
      ->execute()->as_array();
    $asc_a_news = [];
    
    foreach ($arr_a_news as $k => $d) {
      $asc_a_news[$d['question_id']]['css']   = '';
      $asc_a_news[$d['question_id']]['u_img'] = '/assets/img/icon/people.png';
      if ( isset($_GET['follow']) ) {
        foreach ($_GET['follow'] as $kk => $dd) {
          if ( $d['following_u_id'] == $dd ) {
            //$asc_a_news[$d['question_id']]['priority'] = 1;
            if ( $d['u_img'] == '' ) {
              $util = new Model_Util();
              $util->eto($d['following_u_id']);
              $asc_a_news[$d['question_id']]['u_img'] = $util->eto_img;
              $asc_a_news[$d['question_id']]['css']   = $util->eto_css;
            } else {
              $asc_a_news[$d['question_id']]['u_img'] = $d['u_img'];
            }
          }
        }
      }
      $asc_a_news[$d['question_id']]['question_id'] = $d['question_id'];
      $asc_a_news[$d['question_id']]['q_img'] = $d['q_img'] ?: '/assets/img/icon/quiz_generator.png';
    }
    $arr_res = array();  
    foreach ($asc_a_news as $d) {
      $q_img = strip_tags( preg_replace('/http/', 'url', $d['q_img']) );
      $u_img = strip_tags( preg_replace('/http/', 'url', $d['u_img']) );
      $arr_res[] = 
        '<img src="'.$u_img.'" class="icon '.$d['css'].'">&nbsp;'
        .'<img src="/assets/img/icon/answer.png" class="icon">&nbsp;'
        .'<a href="/quiz/?q='.$d['question_id'].'">'
        .'<img src="'.$q_img.'" class="icon edge_click"></a>';
      $res[0] = 1;
    }  
    $res[1] = $arr_res;
    
    $query = DB::query("select * from followed_news where receiver = ".$usr_id)
      ->execute()->as_array();
    DB::query("delete from followed_news where receiver = ".$usr_id)->execute();  
    $arr_res = array();  
    foreach ($query as $d)
    {
      if ($d['sender_img']) {
        $sender_img = $d['sender_img'];
        $css = '';
      } else {
        $util = new Model_Util();
        $util->eto($d['sender']);
        $sender_img = $util->eto_img;
        $css = $util->eto_css;
      }
      
      $arr_res[] = '<a href="/profile/?u='.$d['sender'].'">'
        .'<img src="'.$sender_img.'" class="icon edge_click" '.$css.' ></a>&nbsp;'
        .'<img src="/assets/img/icon/star_0.png" class="icon edge_click" onClick="follow_confirm('.$d['sender'].')">'
        .'&nbsp;<img src="/assets/img/icon/success_0.png" class="icon edge_click" onClick="follow_confirm('.$d['sender'].')">'
        ;
      $res[0] = 1;
    }
    $res[1] = array_merge($res[1], $arr_res);

    $query = DB::query("select * from private_news where usr_id = ".$usr_id)
      ->execute()->as_array();
    DB::query("delete from private_news where usr_id = ".$usr_id)->execute();  
    $arr_res = array();  
    foreach ($query as $d)
    {
      $arr_res[] = $d['txt'];
      $res[0] = 1;
    }
    $res[1] = array_merge($res[1], $arr_res);  
    $query = DB::query("select * from pay_answered_news where usr_id = ".$usr_id)
      ->execute()->as_array();
    DB::query("delete from pay_answered_news where usr_id = ".$usr_id)->execute();  
    $arr_res = array();  
    foreach ($query as $d)
    {
      $q_img = preg_replace('/http/', 'url', $d['q_img']);
      $q_img = $q_img ?: '/assets/img/icon/quiz_generator.png';
      $arr_res[] = $d['summary'].'&nbsp;'.
        '<img src="/assets/img/icon/people.png" class="icon">&nbsp;'.
        '<img src="/assets/img/icon/answer.png" class="icon">&nbsp;'.
        '<a href="/quiz/?q='.$d['question_id'].'">'.
        '<img src="'.$q_img.'" class="icon edge_click"></a>';
      $res[0] = 1;
    }
    $res[1] = array_merge($res[1], $arr_res);
    
//    $query = DB::query("select * from mt_public_news where create_at > '".date('Y-m-d H:i:s',$_GET['last_checked'] * 60 * 60)."' AND create_at < ")
//      ->execute()->as_array();
    $query = DB::query("select * from mt_public_news where create_at > '".date('Y-m-d H:i:s',$_GET['last_checked'] * 60 * 60)."' AND create_at < '".date("Y-m-d H:i:s")."'")
      ->execute()->as_array();
    $arr_res = array();  
    foreach ($query as $d)
    {
      $arr_res[] = $d['txt'];
      $res[0] = 1;
    }
    $res[1] = array_merge($res[1], $arr_res);

    die(json_encode($res));
  }
}
