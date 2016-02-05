<?php
class Controller_Myanswershow extends Controller
{
  public function action_index()
  {
    header("Content-Type: application/json; charset=utf-8");
    $res[0] = 2;
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
        $arr = [];
        foreach ($query as $k => $d) {
          $arr[$k][0] = $d['tag'];
          $arr[$k][1] = $d['cnt'];
          $arr[$k][2] = $d['rank'];
        }
        $res[0] = 1;
        $res[1] = $arr;
        $res[2] = $description;
      }
    }
    die(json_encode($res));  
  }
}
