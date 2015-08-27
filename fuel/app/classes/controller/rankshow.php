<?php
class Controller_Rankshow extends Controller
{
  public function action_index()
  {
    header("Content-Type: application/json; charset=utf-8");
    $res[0] = 2;
    if (!isset($_GET['tag']))
    {
      Model_Log::warn('no tag');
      die(json_encode($res));
    }

    $tag = preg_replace('/\W+/u', '', $_GET['tag']);
    $tag_rank = DB::query(
      "SELECT usr_id, COUNT(*) as cnt, u_name, u_img FROM tag_rank WHERE tag = "
      ." '".$tag."' "
      ." AND create_at > "
      ." '".date('Y-m-d H:i:s',strtotime('-1 month'))."' "
        ." GROUP BY usr_id, u_name, u_img ORDER BY cnt DESC ,usr_id DESC LIMIT 50"
      )->execute()->as_array();    
    $i = 0;
    foreach ($tag_rank as $k => $d)
    {
      
      if ($d['u_name']) {
        $u_name = Str::truncate(Security::htmlentities($d['u_name']), 30);
        $u_img = strip_tags( preg_replace('/http/', 'url', $d['u_img']) );
        $css = '';
      } else {
        $util = new Model_Util();
        $util->eto($d['usr_id']);
        $u_name = $util->eto_txt;
        $u_img = $util->eto_img;
        $css   = $util->eto_css;
      }
      $res[1][$i][0] = $d['usr_id'];
      $res[1][$i][1] = $u_name;
      $res[1][$i][2] = $u_img;
      $res[1][$i][3] = $d['cnt'];
      $res[1][$i][4] = $css;
      $res[0] = 1;
      ++$i;
    }
    die(json_encode($res));    
  }
}
