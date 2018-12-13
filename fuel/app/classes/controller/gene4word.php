<?php
class Controller_Gene4word extends Controller
{
  public function action_index()
  {
    $usr_id = Model_Cookie::get_usr();

    $view = View::forge('generate_4word');
    $view->u_id = $usr_id;
    die($view);
  }
}
