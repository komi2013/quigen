<?php
class Controller_Admintopcreate extends Controller
{
  public function action_index()
  {
    $usr_id = Model_Cookie::get_usr();
    $auth = false;
    foreach (Config::get('my.adm') as $d) {
      if ($d == $usr_id) {
        $auth = true;
      }
    }
    if (!$auth AND $_SERVER['REMOTE_ADDR'] != '153.126.217.154') {
      $view = View::forge('404');
      die($view);
    }
    $top_qu = [];
    $i = 0;
    $query = DB::query( "SELECT * FROM mt_seo_tag" )->execute()->as_array();
    foreach ($query as $d) {
      $arr = DB::query( "SELECT * FROM question WHERE id in ( select question_id from tag where txt = '".$d['tag']."' ) ORDER BY random() LIMIT ".Config::get('my.top_limit') )->execute()->as_array();
      $seq = rand(0, 1000);
      foreach ($arr as $kk => $dd) {
        $top_qu[$i]['tag'] = $d['tag'];
        $top_qu[$i]['question_id'] = $dd['id'];
        $top_qu[$i]['img'] = $dd['img'];
        $txt = Security::htmlentities($dd['txt']);
        $top_qu[$i]['txt'] = $txt;
        $top_qu[$i]['seq'] = $seq;
        ++$i;
      }
    }
    DB::query("DELETE FROM mt_tag_top")->execute();
    $sql = "INSERT INTO mt_tag_top (tag, question_id, img, txt, seq) VALUES ";
    foreach ($top_qu as $k => $d) {
      if ($k < 1) {
        $sql .= "  ('".$d['tag']."',".$d['question_id'].",'".$d['img']."','".$d['txt']."',".$d['seq'].") ";  
      } else {
        $sql .= ", ('".$d['tag']."',".$d['question_id'].",'".$d['img']."','".$d['txt']."',".$d['seq'].") ";  
      }
    }
    try
    {
      DB::query($sql)->execute();
    }
    catch (Orm\ValidationFailed $e)
    {
      die(json_encode($e->getMessage()));
    }
    echo '<pre>'; var_dump($top_qu); echo '</pre>'; die();
  }
}
