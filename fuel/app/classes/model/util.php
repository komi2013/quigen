<?php
class Model_Util extends \Model
{
  public $eto_img;
  public $eto_txt;
  public $eto_css;
  
  public static function warn($warn) 
  {
    $warn = @$_SERVER['SERVER_ADDR'].' '.$_SERVER['REQUEST_URI'].' '.$warn;
    $i = 0;
    foreach ($_POST as $k => $d) {
      $warn = ($i == 0) ? $warn.' POST ' : $warn.' '; 
      $warn .= ' '.$k.'='.$d;
      ++$i;
    }
    
    Log::warning($warn);
  }
  public static function is_mobile() 
  {
    $useragents = array(
      'iPhone',          // iPhone
      'iPod',            // iPod touch
      'Android.*Mobile', // 1.5+ Android Only mobile
      'Windows.*Phone',  // Windows Phone
      'webOS',           // Palm Pre Experimental
      'mobile',       // Other iPhone browser
    );
    $pattern = '/'.implode('|', $useragents).'/i';
    
    if ( !isset($_SERVER['HTTP_USER_AGENT']) ) {
      Model_Log::warn('no HTTP_USER_AGENT');
      return 1;
    }
    return preg_match( $pattern, $_SERVER['HTTP_USER_AGENT'] );
  }
  
  public function eto($u_id) 
  {
    $left   = substr( floor( $u_id / 100), -1 );
    $left = $this->decimal_hexadecimal($left);
    $middle = substr( floor( $u_id / 10), -1 );
    $middle = $this->decimal_hexadecimal($middle);
    $right  = substr( floor( $u_id / 1), -1 );
    $right = $this->decimal_hexadecimal($right);

    $eto_num = ( $u_id % 12 ) + 1;
    switch ($eto_num) {
      case 1:
        $eto_img = '/assets/img/eto/01_rat.png';
        $eto_txt = 'ねずみ';
        break;
      case 2:
        $eto_img = '/assets/img/eto/02_buffalo.png';
        $eto_txt = 'うし';
        break;
      case 3:
        $eto_img = '/assets/img/eto/03_tiger.png';
        $eto_txt = 'とら';
        break;
      case 4:
        $eto_img = '/assets/img/eto/04_rabbit.png';
        $eto_txt = 'うさぎ';
        break;
      case 5:
        $eto_img = '/assets/img/eto/05_dragon.png';
        $eto_txt = 'たつ';
        break;
      case 6:
        $eto_img = '/assets/img/eto/06_snake.png';
        $eto_txt = 'へび';
        break;
      case 7:
        $eto_img = '/assets/img/eto/07_horse.png';
        $eto_txt = 'うま';
        break;
      case 8:
        $eto_img = '/assets/img/eto/08_sheep.png';
        $eto_txt = 'ひつじ';
        break;
      case 9:
        $eto_img = '/assets/img/eto/09_monkey.png';
        $eto_txt = 'さる';
        break;
      case 10:
        $eto_img = '/assets/img/eto/10_hen.png';
        $eto_txt = 'とり';
        break;
      case 11:
        $eto_img = '/assets/img/eto/11_dog.png';
        $eto_txt = 'いぬ';
        break;
      case 12:
        $eto_img = '/assets/img/eto/12_pig.png';
        $eto_txt = 'いのしし';
        break;
    }
    $this->eto_css = 'style="background-color:#'.$left.$left.$middle.$middle.$right.$right.';opacity:0.7;"';
    $this->eto_img = $eto_img;
    $this->eto_txt = $eto_txt.$u_id;
  }
  protected function decimal_hexadecimal($res)
  {
    switch ($res) {
      case 1:
          $res = 'A';
          break;
      case 3:
          $res = 'B';
          break;
      case 5:
          $res = 'C';
          break;
      case 7:
          $res = 'D';
          break;
      case 9:
          $res = 'E';
          break;
    }
    return $res;
  }
  
}