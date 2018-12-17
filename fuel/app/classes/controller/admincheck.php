<?php
class Controller_AdminCheck extends Controller
{
  public function action_index()
  {
    $usr_id = Model_Cookie::get_usr();
    $auth = false;
    foreach (Config::get('my.adm') as $d)
    {
      if ($d == $usr_id)
      {
        $auth = true;
      }
    }
    if (!$auth AND $_SERVER['REMOTE_ADDR'] != '133.18.20.148')
    {
      $view = View::forge('404');
      
      die($view);
    }
    //echo $HTTPD,$DB,$DISK,$READ,$WRITE,$FREEMEM,$CPU,`date +"%k:%M:%S"` >> monitor.log_`date +%Y%m%d`
    $arr_httpd = array(0,0);
    $arr_db = array(0,0);
    $arr_disk = array(0,0);
    $arr_read = array(0,0);
    $arr_write = array(0,0);
    $arr_freemem = array(2000,0);
    $arr_cpu = array(0,0);
    if (($handle = @fopen(Config::get('my.dir').'monitor_log/monitor_'.date('Ym',strtotime('-1 day')).'.csv', "r")) !== FALSE) {
      while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
        if ($arr_httpd[0] < $data[0]) {
          $arr_httpd[0] = $data[0];
          $arr_httpd[1] = $data[7];
        }
        if ($arr_db[0] < $data[1]) {
          $arr_db[0] = $data[1];
          $arr_db[1] = $data[7];
        }
        if ($arr_disk[0] < $data[2]) {
          $arr_disk[0] = $data[2];
          $arr_disk[1] = $data[7];
        }
        if ($arr_read[0] < $data[3]) {
          $arr_read[0] = $data[3];
          $arr_read[1] = $data[7];
        }
        if ($arr_write[0] < $data[4]) {
          $arr_write[0] = $data[4];
          $arr_write[1] = $data[7];
        }
        if ($arr_freemem[0] > $data[5]) {
          $arr_freemem[0] = $data[5];
          $arr_freemem[1] = $data[7];
        }
        if ($arr_cpu[0] < $data[6]) {
          $arr_cpu[0] = $data[6];
          $arr_cpu[1] = $data[7];
        }
      }
      fclose($handle);
    }
    $count = DB::query("
      SELECT relname, n_tup_ins - n_tup_del as rowcount 
      FROM pg_stat_all_tables
      WHERE relname not like 'pg_%' AND relname not like 'sql_%' ORDER BY relname
      ")->execute()->as_array();

    $mail = View::forge('monitor_mail');
    $mail->count = $count;
    $mail->arr_httpd = $arr_httpd;
    $mail->arr_db = $arr_db;
    $mail->arr_disk = $arr_disk;
    $mail->arr_read = $arr_read;
    $mail->arr_write = $arr_write;
    $mail->arr_freemem = $arr_freemem;
    $mail->arr_cpu = $arr_cpu;
    
    $y = date('Y',strtotime('-1 day'));
    $m = date('m',strtotime('-1 day'));
    $d = date('d',strtotime('-1 day'));
    $mail->err_log = shell_exec('tail '.APPPATH.'logs/'.$y.'/'.$m.'/'.$d.'.php');
    
    mb_language("Ja") ;
    mb_internal_encoding("UTF-8") ;
    $mailto = "seijirok@gmail.com";
    $subject = "monitor result ".date('Y-m-d H:i:s');
    $content = $mail;
    $mailfrom="From:" .mb_encode_mimeheader("クイジェン") .Config::get('my.dir')."<generator@mail.quigen.info>";
    $res = mb_send_mail($mailto,$subject,$content,$mailfrom);
    var_dump($res);
    $arrtest['ddd'] = 'i';
    $arrtest['dod'] = 'o';
    die();
  }
}
