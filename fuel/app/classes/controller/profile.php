<?php
class Controller_Profile extends Controller
{
  public function action_index()
  {
    if ( !isset($_GET['u']) OR !is_numeric($_GET['u']) ) {
      $view = View::forge('404');
      die($view);
    }
    $usr_id = Model_Cookie::get_usr();
    $view = View::forge('profile');
    
    $usr = Model_Usr::find('first', array(
      'where' => array(
        array('id', '=',$_GET['u']),
      ),
    ));
    $view->usr_id = $_GET['u'];

    $util = new Model_Util();
    $util->eto($_GET['u']);
    $view->usr_name = $util->eto_txt;
    $view->usr_img  = $util->eto_img;
    $view->css  = $util->eto_css;
    $view->introduce = '';
    $introduce = '';
    if ( isset($usr->id) )
    {
      $view->usr_name = Security::htmlentities($usr->name);
      $view->usr_img = $usr->img ? Security::htmlentities($usr->img) : $util->eto_img;
      $view->css = '';
      
      $param = preg_replace('/　/', ' ', $usr->introduce);
      $param = preg_replace('/\s+/', ' ', $param);
      $arr_keyword = explode(' ', $param);
      
      foreach ($arr_keyword as $d) {
        if( preg_match('/^(http|https):\/\/([A-Z0-9][A-Z0-9_-]*(?:\.[A-Z0-9][A-Z0-9_-]*)+):?(\d+)?\/?/i', $d) ) {
          $introduce .= ' '.Html::anchor($d, $d);
        } else {
          $introduce .= ' '.Security::htmlentities($d);
        }
      }
      $introduce = $introduce;
    }

    $res = DB::query("select count(*) from question where usr_id = ".$_GET['u'])->execute()->as_array();
    $view->num_quiz = $res[0]['count'];
    $res = DB::query("SELECT * FROM follow WHERE receiver = ".$_GET['u'])->execute()->as_array();
    $cnt_follower = 0;
    $status = 0;
    foreach ($res as $k => $d) {
      if ($d['sender'] == $usr_id) {
        $status = $d['status'];
      }
      if ( $d['status'] == 2 ) {
        ++$cnt_follower;
      }
    }
    $view->status = $status;
    $view->follower = $cnt_follower;
    $res = DB::query("select count(*) from answer_key_u where usr_id = ".$_GET['u']." AND create_at > '".date('Y-m-d H:i:s',strtotime('-1 week'))."'" )->execute()->as_array();
    if ($res[0]['count'] > 0) {
      $answer_cnt_1week = '1週間で'.$res[0]['count'].'件回答しました。';  
    } else {
      $answer_cnt_1week = '';
    }
    if (!$introduce AND !$answer_cnt_1week) {
      $view->introduce = '自己紹介：';
    } else {
      $view->introduce =   $answer_cnt_1week.$introduce;
    }
    $view->answer_cnt_1week = $answer_cnt_1week;
    $res = DB::query("select count(*) from follow where sender = ".$_GET['u']." AND status = 2")->execute()->as_array();
    $view->following = $res[0]['count'];
    $view->u_id = $usr_id;
    $description = '';
    if( !isset($_GET['list']) ){
      $res = DB::query("
        select tag, usr_id,cnt,rank from (
          select tag, usr_id, cnt, rank() over(PARTITION BY tag order by cnt desc) as rank from (
            select tag ,usr_id ,count(*) as cnt from tag_rank where create_at > "
              ." '".date('Y-m-d H:i:s',strtotime('-1 month'))."' "."
              group by tag,usr_id
              order by tag desc, cnt desc
          ) as rank_by_correct
        ) as correct_rank
        where usr_id = ".$_GET['u']."
        order by cnt desc
      ")->execute()->as_array();
      $i = 0;
      foreach($res as $k => $d){
        if($i < 5){
          $description .= $d['tag'];
          $description .= ' 正解数'.$d['cnt'].'で';
          $description .= $d['rank'].'位';
          ++$i; 
        }
      }
      $view->rank = $res;
    }
    $view->description = $description;
    $view->meta_description = strip_tags($introduce).$description;
    $view->fb_url = 'http://www.facebook.com/sharer.php?u=http://'
      .Config::get('my.domain')
      .'/profile/?u='.$_GET['u'].'%26cpn=share_fb';
    $view->tw_url = 'https://twitter.com/intent/tweet?url=http://'
      .Config::get('my.domain')
      .'/profile/?u='.$_GET['u'].'%26cpn=share_tw'
      .'&text='.$description.'+@quigen2015';
    $view->ln_url = 'line://msg/text/?'.$description.'%0D%0Ahttp://'
      .Config::get('my.domain')
      .'/profile/?u='.$_GET['u'].'%26cpn=share_ln';
    $view->clip_url = 'http://'
      .Config::get('my.domain')
      .'/profile/?u='.$_GET['u'];
    die($view);
  }
}
