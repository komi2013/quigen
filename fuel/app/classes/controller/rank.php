<?php
class Controller_Rank extends Controller
{
  public function action_index()
  {
    $query = DB::query("SELECT * FROM (
      SELECT tag, count(*) FROM tag_rank GROUP BY tag
        ) as rank
      ORDER BY rank.count DESC ")->execute()->as_array();
    $tag_rank = [];
    foreach ($query as $k => $d) {
      $tag_rank[$k] = $d;
      $tag_rank[$k]['tag'] = Str::truncate(Security::htmlentities( $d['tag'] ), 200);
    }
    $view = View::forge('rank');
    $view->tag_rank = $tag_rank;
    return $view;
  }
}
