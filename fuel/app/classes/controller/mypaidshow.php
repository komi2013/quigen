<?php
class Controller_Mypaidshow extends Controller
{
  public function action_index()
  {
    $res[0] = 2;
    $query = DB::select()->from('paid_usr')
      ->where('usr_id','=',Model_Cookie::get_usr())
      ->execute();
    foreach ($query as $d)
    {
      $arr_pack[] = $d['pack_id'];
    }

    if (!isset($arr_pack[0]))
    {
      die(json_encode($res));
    }

    if ($_GET['endNum'] > 0)
    {
      $query = DB::select()->from('pack')
        ->where('id','in',$arr_pack)
        ->and_where('id','<',$_GET['endNum'])
        ->order_by('id','desc')
        ->limit(100)
        ->execute();
    }
    else
    {
      $query = DB::select()->from('pack')
        ->where('id','in',$arr_pack)
        ->order_by('id','desc')
        ->limit(100)
        ->execute();
    } 
    $i = 0;
    foreach ($query as $k => $d)
    {
      $res[1][$i][0] = $d['id'];
      $res[1][$i][1] = Security::htmlentities($d['txt']);
//       $res[1][$i][2] = $d['img'];
      $res[0] = 1;
      ++$i;
    }
    die(json_encode($res));    
  }
}
