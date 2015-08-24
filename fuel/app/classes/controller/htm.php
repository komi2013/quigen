<?php
class Controller_Htm extends Controller
{
  public function action_index()
  {
    Model_Csrf::setcsrf();
    if ( !isset($_GET['p']) ) {
      Model_Log::warn('no p');
      die( View::forge('404') );
    }
    $view = View::forge('htm_'.$_GET['p']);
    $view->u_id = Model_Cookie::get_usr();
    die($view);
  }
  public function action_all()
  {
    Model_Csrf::setcsrf();
    $slash = explode( '/', $_SERVER['REQUEST_URI'] );
    if ( isset($slash[2]) ) {
      $view = View::forge('htm/'.$slash[2]);
      $view->u_id = Model_Cookie::get_usr();
      die($view);
    } else {
      die( View::forge('404') );
    }
  }

}
