<?php
class Controller_Profile extends Controller
{
  public function action_index()
  {
    if ( !isset($_GET['u']) OR !is_numeric($_GET['u']) )
    {
      $view = View::forge('404');
      
      die($view);
    }
    Model_Csrf::setcsrf();
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
    
    if ( isset($usr->id) )
    {
      $view->usr_name = Security::htmlentities($usr->name);
      $view->usr_img = Security::htmlentities($usr->img);
      $view->css = '';
      
      $param = preg_replace('/　/', ' ', $usr->introduce);
      $param = preg_replace('/\s+/', ' ', $param);
      $arr_keyword = explode(' ', $param);
      $introduce = '';
      foreach ($arr_keyword as $d) {
        if( preg_match('/^(http|https):\/\/([A-Z0-9][A-Z0-9_-]*(?:\.[A-Z0-9][A-Z0-9_-]*)+):?(\d+)?\/?/i', $d) ) {
          $introduce .= ' '.Html::anchor($d, $d);
        } else {
          $introduce .= ' '.Security::htmlentities($d);
        }
      }
      $view->introduce = $introduce;
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
    $res = DB::query("select count(*) from follow where sender = ".$_GET['u']." AND status = 2")->execute()->as_array();
    $view->following = $res[0]['count'];
    $view->u_id = $usr_id;
    
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
      $view->rank = $res;
    } 
    die($view);
  }
}
