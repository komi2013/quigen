<?php
class Controller_Myanswer extends Controller
{
  public function action_index()
  {
    $view = View::forge('myanswer');
    $usr_id = Model_Cookie::get_usr();
    $description = '';
    if ($usr_id) {
      $query = DB::query("
        select tag, usr_id,cnt,rank from (
          select tag, usr_id, cnt, rank() over(PARTITION BY tag order by cnt desc) as rank from (
            select tag ,usr_id ,count(*) as cnt from tag_rank where create_at > "
              ." '".date('Y-m-d H:i:s',strtotime('-1 month'))."' "."
              group by tag,usr_id
              order by tag desc, cnt desc
          ) as rank_by_correct
        ) as correct_rank
        where usr_id = ".$usr_id."
        order by cnt desc
      ")->execute()->as_array();
      $i = 0;
      if ( isset($query) ) {
        foreach($query as $k => $d){
          if($i < 5){
            $description .= $d['tag'];
            $description .= ' 正解数'.$d['cnt'].'で';
            $description .= $d['rank'].'位';
            ++$i; 
          }
        }
        $view->rank = $query;
      }
    }
    $view->fb_url = 'http://www.facebook.com/sharer.php?u=http://'
      .Config::get('my.domain')
      .'/profile/?u='.$usr_id.'%26cpn=share_fb';
    $view->tw_url = 'https://twitter.com/intent/tweet?url=http://'
      .Config::get('my.domain')
      .'/profile/?u='.$usr_id.'%26cpn=share_tw'
      .'&text='.$description.'+@quigen2015';
    $view->ln_url = 'line://msg/text/?'.$description.'%0D%0Ahttp://'
      .Config::get('my.domain')
      .'/profile/?u='.$usr_id.'%26cpn=share_ln';
    $view->clip_url = 'http://'
      .Config::get('my.domain')
      .'/profile/?u='.$usr_id;
    $view->usr_id = $usr_id;
    die($view);
  }
}
