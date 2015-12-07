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
    if (!$auth AND $_SERVER['REMOTE_ADDR'] != '133.242.146.131') {
      $view = View::forge('404');
      die($view);
    }
    $top_qu = [];
    $i = 0;
    $arr_tag = [
        '中学歴史'   
        ,'センター日本史'
        ,'センター世界史'
        ,'センター化学'
        ,'センター生物'
        ,'センター英語初級'
        ,'センター英語中級'
        ,'センター英語上級'
        ,'大学受験英熟語'
        ,'休憩'
      ];
    foreach ($arr_tag as $d) {
      $arr = DB::query("SELECT * FROM question WHERE id in ( select question_id from tag where txt = '".$d."' ) ORDER BY random() LIMIT 2")->execute()->as_array();
      $seq = rand(0, 1000);
      foreach ($arr as $kk => $dd) {
        $top_qu[$i]['tag'] = $d;
        $top_qu[$i]['question_id'] = $dd['id'];
        $top_qu[$i]['img'] = $dd['img'];
        $top_qu[$i]['txt'] = $dd['txt'];
        $top_qu[$i]['seq'] = $seq;
        ++$i;
      }
    }
    $sql = "INSERT INTO mt_tag_top (tag, question_id, img, txt, seq) VALUES ";
    foreach ($top_qu as $k => $d) {
      if ($k < 1) {
        $sql .= "  ('".$d['tag']."',".$d['question_id'].",'".$d['img']."','".$d['txt']."',".$d['seq'].") ";  
      } else {
        $sql .= ", ('".$d['tag']."',".$d['question_id'].",'".$d['img']."','".$d['txt']."',".$d['seq'].") ";  
      }
    }
    //var_dump($sql); die();
    try
    {
      DB::query($sql)->execute();
    }
    catch (Orm\ValidationFailed $e)
    {
      die(json_encode($e->getMessage()));
    }
    echo '<pre>'; var_dump($top_qu); echo '</pre>'; die();

    //$res[0] = 1;
    //die(json_encode($res));
  }
}
