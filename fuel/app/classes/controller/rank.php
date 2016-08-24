<?php
class Controller_Rank extends Controller
{
  public function action_index()
  {
    $sql = "SELECT * FROM (
              SELECT tag, count(*) FROM tag_rank WHERE create_at > '".date('Y-m-d H:i:s',strtotime('-1 month'))."' GROUP BY tag
            ) as rank
            ORDER BY rank.count DESC ";
    $arr = DB::query($sql)->execute()->as_array();
    $tag_group = [];
//    $tag = '';
    foreach ($arr as $k => $d) {
      $tag_group[$k] = $d;
      $tag_group[$k]['tag'] = Str::truncate(Security::htmlentities( $d['tag'] ), 200);
//      if ($k < 1) {
//        $tag = $tag_group[$k]['tag'];
//      }
    }
//
//    if ( isset($_GET['tag']) ) {
//      $tag = $_GET['tag'];
//    }
//    $tag = preg_replace('/#/u', '', $tag);
//    $sql = "SELECT usr_id, COUNT(*) as cnt, u_name, u_img FROM tag_rank WHERE tag = "
//      ." :tag "
//      ." AND create_at > "
//      ." '".date('Y-m-d H:i:s',strtotime('-1 month'))."' "
//      ." GROUP BY usr_id, u_name, u_img ORDER BY cnt DESC ,usr_id DESC LIMIT 50";
//    $rank = DB::query($sql)->bind('tag', $tag)->execute()->as_array();    

    $view = View::forge('rank');
    $view->tag_group = $tag_group;
    //$view->rank = $rank;
    return $view;
  }
}
