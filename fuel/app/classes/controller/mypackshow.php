<?php
class Controller_Mypackshow extends Controller
{
  public function action_index()
  {
    $res[0] = 2;
    if( !isset($_GET['endNum']) OR !is_numeric($_GET['endNum']) ) {
      Model_Log::warn('no endNum');
      die(json_encode($res));
    }
    $usr_id = Model_Cookie::get_usr();
    if (!$usr_id)
    {
      //Model_Log::warn('no usr');
      die(json_encode($res));
    }
    if ($_GET['endNum'] > 0)
    {
      $query = DB::select()->from('pack')
        ->where('usr_id','=',$usr_id)
        ->and_where('id','<',$_GET['endNum'])
        ->order_by('id','desc')
        ->limit(100)
        ->execute();
    }
    else
    {
      $query = DB::select()->from('pack')
        ->where('usr_id','=',$usr_id)
        ->order_by('id','desc')
        ->limit(100)
        ->execute();
    } 
    $i = 0;
    $activate = 2;
    foreach ($query as $k => $d)
    {
      $res[1][$i][0] = $d['id'];
      $res[1][$i][1] = Str::truncate(Security::htmlentities($d['txt']), 30);
      $res[1][$i][2] = $d['activate'];
      $res[0] = 1;
      if ($d['activate'] == 0)
      {
        $activate = 0;
      }
      ++$i;
    }
    $res[2] = $activate;
    die(json_encode($res));    
  }
}
