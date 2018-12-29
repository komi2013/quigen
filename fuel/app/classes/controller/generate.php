<?php
class Controller_Generate extends Controller
{
  public function action_index()
  {
    $usr_id = Model_Cookie::get_usr();
    $q_type = 'textbox';
    if ( Input::get('q_type') == 'choice') {
        $q_type = 'choice';
    }
    $view = View::forge('generate');
    $view->u_id = $usr_id;
    $view->q_type = $q_type;
    
    die($view);
  }
}
