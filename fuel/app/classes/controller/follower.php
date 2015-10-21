<?php
class Controller_Follower extends Controller
{
  public function action_index()
  {
    if( !isset($_GET['u']) OR !is_numeric($_GET['u']) ) {
      $view = View::forge('404');
      
      die($view);
    }
    $usr = Model_Usr::find('first', array(
      'where' => array(
        array('id', '=',$_GET['u']),
      ),
    ));
    $view = View::forge('follower');
    $view->receiver = $_GET['u'];
    $view->usr_id = Model_Cookie::get_usr();
    $util = new Model_Util();
    $util->eto($_GET['u']);
    $view->usr_img = $util->eto_img;
    $view->css = $util->eto_css;
    if ( isset($usr->id) )
    {
      $view->usr_img = $usr->img;
      $view->css = '';
    } else {
      $view = View::forge('404');
      
      die($view);
    }
    
    die($view);
  }
}
