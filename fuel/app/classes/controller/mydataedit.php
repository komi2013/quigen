<?php
class Controller_Mydataedit extends Controller
{
  public function action_index()
  {
    $res[0] = 2;
    Model_Csrf::check();
    $usr_id = Model_Cookie::get_usr();
    if (!$usr_id)
    {
      $usr_id = 0;
    }

    $arr_mydata_db = DB::query("select * from mydata where usr_id = ".$usr_id)->execute()->as_array();
    if (isset($arr_mydata_db[0]['answer_by_u'])) {
      $arr_mydata_before[0] = $arr_mydata_db[0]['answer_by_u'];
      $arr_mydata_before[1] = $arr_mydata_db[0]['answer'];
    } else {
      $arr_mydata_before[0] = '';
      $arr_mydata_before[1] = '';
    }
    if (isset($_POST['answer_by_u'])) {
      $post_answer_by_u = $_POST['answer_by_u'];
      $post_answer = $_POST['answer'];
    } else {
      $post_answer_by_u = '';
      $post_answer = '';
    }
    $arr_answer_by_u_now = json_decode($post_answer_by_u) ?: array(0,0);
    $arr_answer_by_u_before = json_decode($arr_mydata_before[0]) ?: array(0,0);
    $arr_answer_now = json_decode($post_answer) ?: array();
    $arr_answer_before = json_decode($arr_mydata_before[1]) ?: array();

    if ($arr_answer_by_u_now[1] > $arr_answer_by_u_before[1]) {
      $arr_answer_by_u = $arr_answer_by_u_now; 
    } else {
      $arr_answer_by_u = $arr_answer_by_u_before;
    }
    $arr_answer = $arr_answer_now + $arr_answer_before;
    rsort($arr_answer);
    $arr_answer_new = array();
    $pre = 0;
    foreach ($arr_answer as $d)
    {
      if (isset($d[0]))
      {
        if ($pre == $d[0])
        {
          continue;
        }
        $arr_answer_new[] = $d;
        $pre = $d[0];
      }
    }
    DB::query("delete from mydata where usr_id = ".$usr_id)->execute();
    $json_answer_by_u = json_encode($arr_answer_by_u);
    $json_answer_new = json_encode($arr_answer_new);
    if ($usr_id > 0) {
      $mydata = new Model_Mydata();
      $mydata->usr_id = $usr_id;
      $mydata->answer_by_u = $json_answer_by_u;
      $mydata->answer = $json_answer_new;
      $mydata->update_at = date("Y-m-d H:i:s");
      $mydata->save();
    }
    $res[0] = 1;
    die(json_encode($res));
  }
}
