<?php
class Controller_Htm extends Controller
{

  public function action_all()
  {
    $expires = 3600 * 24;
    header('Last-Modified: Fri Jan 01 2010 00:00:00 GMT');
    header('Expires: ' . gmdate('D, d M Y H:i:s T', time() + $expires));
    header('Cache-Control: private, max-age=' . $expires);
    header('Pragma: ');
    $file = $this->param('one');
    $is = false;
    if (file_exists(APPPATH.'views/htm/'.$file.'.php')) {
        $view = View::forge('htm/'.$file);
        $view->u_id = Model_Cookie::get_usr();
        die($view);        
    }
    if ( file_exists(APPPATH.'views/htm/'.$file.'_'.Config::get("my.lang").'.php') ) {
        
    }
    die( View::forge('404') );
  }

}
