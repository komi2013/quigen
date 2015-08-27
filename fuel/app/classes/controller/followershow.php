<?php
class Controller_Followershow extends Controller
{
  public function action_index()
  {
    header("Content-Type: application/json; charset=utf-8");
    $res[0] = 2;
    if ($_GET['endNum'] > 0)
    {
      $follower = DB::select()->from('follow')
        ->where('receiver','=',$_GET['receiver'])
        ->and_where('id','<',$_GET['endNum'])
        ->order_by('id', 'desc')
        ->limit(100)
        ->execute()
        ->as_array();
    }
    else
    {
      $follower = DB::select()->from('follow')
        ->where('receiver','=',$_GET['receiver'])
        ->order_by('id', 'desc')
//       ->offset($_GET['endNum'])
        ->limit(100)
        ->execute()
        ->as_array();
    }
    $asc_status = [];
    foreach ($follower as $k => $d)
    {
      $arr[] = $d['sender'];
      $asc_status[$d['sender']] = $d['status'];
    }
    if(isset($arr))
    {
      $follower = Model_Usr::find('all', array(
        'where' => array(
          array('id', 'in',$arr),
//         array('provider', 1),
        ),
//          'order_by' => array('id' => 'desc'),
//          array('limit' => 100),
      ));
      $i = 0;
      foreach ($follower as $k => $d)
      {
        $res[1][$i][0] = $d->id;
        $res[1][$i][1] = Security::htmlentities($d->name);
        $res[1][$i][2] = $d->img;
        $res[1][$i][3] = $asc_status[$d->id];
        $res[0] = 1;
        ++$i;
      }
      
    }
    die(json_encode($res));
  }
}
