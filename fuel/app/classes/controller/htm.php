<?php
class Controller_Htm extends Controller
{
  public function action_index()
  {
    $expires = 3600 * 24;
    header('Last-Modified: Fri Jan 01 2010 00:00:00 GMT');
    header('Expires: ' . gmdate('D, d M Y H:i:s T', time() + $expires));
    header('Cache-Control: private, max-age=' . $expires);
    header('Pragma: ');
    if ( !isset($_GET['p']) ) {
      die( View::forge('404') );
    }
    if ( !file_exists(APPPATH.'views/htm_'.$_GET['p'].'.php') ) {
      die( View::forge('404') );
    }
    $view = View::forge('htm_'.$_GET['p']);
    $view->u_id = Model_Cookie::get_usr();
    die($view);
  }
  public function action_all()
  {
    $expires = 3600 * 24;
    header('Last-Modified: Fri Jan 01 2010 00:00:00 GMT');
    header('Expires: ' . gmdate('D, d M Y H:i:s T', time() + $expires));
    header('Cache-Control: private, max-age=' . $expires);
    header('Pragma: ');
    $slash = explode( '/', $_SERVER['REQUEST_URI'] );
    if ( !isset($slash[2]) ) {
      die( View::forge('404') );
    }
    if ( !file_exists(APPPATH.'views/htm/'.$slash[2].'.php') ) {
      die( View::forge('404') );
    }
    $view = View::forge('htm/'.$slash[2]);
    $view->u_id = Model_Cookie::get_usr();
    die($view);
  }

}
