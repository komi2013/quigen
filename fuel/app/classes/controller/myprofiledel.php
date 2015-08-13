<?php
class Controller_MyprofileDel extends Controller
{
  public function action_index()
  {
    $res[0] = 2;
    Model_Csrf::check();
    foreach ($_COOKIE as $k => $d) {
      Cookie::delete($k);
    }
    $res[0] = 1;
    die(json_encode($res));
  }
}
