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
    
//    $usr = Model_Usr::find('first', array(
//      'where' => array(
//        array('id', '=',$_GET['u']),
//      ),
//    ));
    $usr = DB::select()->from('usr')
      ->where('id','=',$_GET['u'])
      ->execute()->as_array();
    $view->usr_id = $_GET['u'];

    $util = new Model_Util();
    $util->eto($_GET['u']);
    $view->usr_name = $util->eto_txt;
    $view->usr_img  = $util->eto_img;
    $view->css  = $util->eto_css;
    $introduce = '';
    $nice = 0;
    $certify = 0;
    $amt_forum = 0;
    $amt_quiz = 0;
    $point = 0;
    if ( isset($usr[0]['id']) ) {
      $view->usr_name = Security::htmlentities($usr[0]['name']);
      $view->usr_img = $usr[0]['img'] ? Security::htmlentities($usr[0]['img']) : $util->eto_img;
      $view->css = '';
      
      $param = preg_replace('/　/', ' ', $usr[0]['introduce']);
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
      $nice = $usr[0]['nice'];
      $certify = $usr[0]['certify'];
      $amt_forum = $usr[0]['forum'] + $usr[0]['forum_comment'];
      $amt_quiz = $usr[0]['quiz'];
      $point = $usr[0]['point'];
    }
    $res = DB::query("select count(*) as cnt from answer_key_u where usr_id = ".$_GET['u'])->execute()->as_array();
    $amt_answer = $res[0]['cnt'];
    $seo_index = false;
    if ($introduce) {
      $seo_index = true;
    }
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
    $view->seo_index = $seo_index;
    $view->status = $status;
    $view->follower = Model_Number::big_number($cnt_follower);
    $res = DB::query("select count(*) from answer_key_u where usr_id = ".$_GET['u']." AND create_at > '".date('Y-m-d H:i:s',strtotime('-1 week'))."'" )->execute()->as_array();
    if ($res[0]['count'] > 0) {
      $answer_cnt_1week = $res[0]['count'].' answer within a week';  
    } else {
      $answer_cnt_1week = '';
    }
    if (!$introduce AND !$answer_cnt_1week) {
      $introduce = 'introduce：';
    } else {
      $introduce =   $answer_cnt_1week.$introduce;
    }
    $view->answer_cnt_1week = $answer_cnt_1week;
    $res = DB::query("select count(*) from follow where sender = ".$_GET['u']." AND status = 2")->execute()->as_array();
    $view->following = Model_Number::big_number($res[0]['count']);
    $view->u_id = $usr_id;
    $description = '';
    if( !isset($_GET['list']) ){
      $arr = [];
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
          $description .= Security::htmlentities($d['tag']);
          $description .= $d['cnt'].' correct answer';
          $description .= 'No.'.$d['rank'];
          ++$i; 
        }
        $arr[$k] = $d;
        $arr[$k]['tag'] = Security::htmlentities($d['tag']);
        $arr[$k]['url_tag'] = urlencode($d['tag']);
      }
      $view->rank = $arr;
    }
    $list = 'answer';
    $arr_list = []; $day = []; $msg_list = [];
    if ( isset($_GET['list']) AND $_GET['list'] == 'quiz') {
      $list = 'quiz';
    } else if ( isset($_GET['list']) AND $_GET['list'] == 'forum') {
      $arr = DB::query("select * from forum_comment where usr_id = ".$_GET['u'].
              " order by open_time desc limit 20")->execute()->as_array();
      $arr_forum_id = '0';
      foreach ($arr as $k => $d) {
        $arr1 = [];
        $arr1['forum_id'] = $d['forum_id'];
        $arr1['txt'] = $d['txt'];
        $arr1['img'] = $d['img'];
        $date = new DateTime($d['open_time']);
        $arr1['open_time'] = $date->format('M/jS').' '.$date->format('D');
        $arr1['question_id'] = 0;
        $arr_list[$d['forum_id']] = $arr1;
        $arr_forum_id .= ','.$d['forum_id'];
      }

      $arr = DB::query("select * from forum where usr_id = ".$_GET['u'].
              " OR id in ( ".$arr_forum_id." )".
              " order by open_time desc limit 20")->execute()->as_array();
      foreach ($arr as $k => $d) {
        if ($d['usr_id'] == $_GET['u']) {
            $arr1['forum_id'] = $d['id'];
            $arr1['txt'] = $d['txt'];
            $arr1['img'] = $d['img'];
            $date = new DateTime($d['open_time']);
            $arr1['open_time'] = $date->format('M/jS').' '.$date->format('D');
            $arr1['question_id'] = $d['question_id'];
            $arr_list[$d['id']] = $arr1;
        } else if( isset($arr_list[$d['id']]['question_id']) ) {  //from forum_comment
            $arr_list[$d['id']]['question_id'] = $d['question_id'];
        }
      }
      $arr_open_time = [];
      foreach ($arr_list as $k => $d) {
          $arr_open_time[$k] = $d['open_time'];
      }
      array_multisort($arr_open_time, SORT_DESC, $arr_list);
      $list = 'forum';
    } else if ( isset($_GET['list']) AND $_GET['list'] == 'graph') {
      $date = new DateTime();
      $i = 0;
      while ($i < 61) {
        $key_day = $date->format('M/jS');
        $arr1['day'] = $key_day.' '.$date->format('D');
        $arr1['answer'] = 0;
        $arr1['spend'] = 0;
        $arr1['time'] = 0;
        $day[$key_day] = $arr1;
        $date->sub(new DateInterval('P1D'));
        ++$i;
      }
      $sql = "SELECT * FROM answer_by_day WHERE usr_id = "
                .$_GET['u']." AND day < '".date("Y-m-d H:i:s")."' AND day > '".date("Y-m-d H:i:s",strtotime('-61 day'))."'"
                ." ORDER BY day DESC";
      $arr = DB::query($sql)->execute()->as_array();
      $max = 1;
      foreach ($arr as $k => $d) {
        $date = new DateTime($d['day']);
        $key_day = $date->format('M/jS');
        $day[$key_day]['day'] = $key_day.' '.$date->format('D');
        if ( isset($day[$key_day]['answer']) ) {
          $day[$key_day]['answer'] = $day[$key_day]['answer'] + $d['answer'];
          $day[$key_day]['spend'] = $day[$key_day]['spend'] + $d['spend'];            
        } else {
          $day[$key_day]['answer'] = $d['answer'];
          $day[$key_day]['spend'] = $d['spend'];            
        }
        $day[$key_day]['time'] = Model_Time::s2h($day[$key_day]['spend']);
        if ($day[$key_day]['answer'] > $max) {
          $max = $day[$key_day]['answer'];
        }
      }
      $view->max = $max;
      $list = 'graph';
    } else if ( isset($_GET['list']) AND $_GET['list'] == 'msg' AND $usr_id) {
      $sql = "select * from message where ( sender = ".$_GET['u']." AND receiver = ".$usr_id." ) OR ( sender = "
              .$usr_id." AND receiver = ".$_GET['u']." ) ORDER BY create_at DESC ";
      $arr = DB::query($sql)->execute()->as_array();
      foreach ($arr as $k => $d) {
        $msg_list[$k] = $d;
        $date = new DateTime($d['create_at']);
        $key_day = $date->format('M/jS');
        $msg_list[$k]['create_at'] = $date->format('M/jS').' '.$date->format('D');
      }
      $list = 'msg';
    }
    $view->arr_list = $arr_list;
    $view->day = $day;
    $view->msg_list = $msg_list;
    $view->list = $list;
    $view->description = $description;
    $view->introduce = $introduce;
    $view->nice = Model_Number::big_number($nice);
    $view->certify = $certify;
    $view->amt_forum = $amt_forum;
    $view->amt_answer = $amt_answer;
    $view->point = Model_Number::big_number($point);
    $view->meta_description = strip_tags($introduce).$description;
    $view->fb_url = 'https://www.facebook.com/sharer.php?u=https://'
      .Config::get('my.domain')
      .'/profile/?u='.$_GET['u'].'%26cpn=share_fb';
    $view->tw_url = 'https://twitter.com/intent/tweet?url=https://'
      .Config::get('my.domain')
      .'/profile/?u='.$_GET['u'].'%26cpn=share_tw'
      .'&text='.$description.'+@quigen2015';
    $view->ln_url = 'line://msg/text/?'.$description.'%0D%0Ahttps://'
      .Config::get('my.domain')
      .'/profile/?u='.$_GET['u'].'%26cpn=share_ln';
    $view->clip_url = 'https://'
      .Config::get('my.domain')
      .'/profile/?u='.$_GET['u'];
    die($view);
  }
}
