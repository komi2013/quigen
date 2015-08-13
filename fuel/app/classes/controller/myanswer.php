<?php
class Controller_Myanswer extends Controller
{
  public function action_index()
  {
    $view = View::forge('myanswer');
    $usr_id = Model_Cookie::get_usr();

    if ($usr_id) {
      $res = DB::query("
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
      if ( isset($res) ) {
        $view->rank = $res;
      }
    }
    $view->usr_id = $usr_id;
    
    
    
/*    
select tag, usr_id,cnt,rank from (
  select tag, usr_id, cnt, rank() over(PARTITION BY tag order by cnt desc) as rank from (
  select tag ,usr_id ,count(*) as cnt from tag_rank where create_at > '2015-04-01 00:00:00'
  group by tag,usr_id
  order by tag desc, cnt desc
  ) as rank_by_correct
) as correct_rank
where usr_id = 137  
*/    
    
    
    die($view);
  }
}
