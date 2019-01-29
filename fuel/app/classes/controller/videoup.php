<?php
class Controller_Videoup extends Controller
{
  public function action_index()
  {

    @mkdir(DOCROOT.'assets/img/video/'.date('Ymd'), 0777);
    @chmod(DOCROOT.'assets/img/video/'.date('Ymd'), 0777);

//    fd.append('room', roomName);
//    fd.append('media', 'audio');
//    fd.append('u_id', localStorage.ua_u_id);
//    fd.append('split', splitAudio);
    
    $uploadfile = DOCROOT.'assets/img/video/'.date('Ymd').'/'.
            $_POST['room'].'_'.$_POST['media'].'_'.$_POST['u_id'].'_'.$_POST['split'].'.webm';
    if ( move_uploaded_file($_FILES['data']['tmp_name'], $uploadfile) ) {
        echo "File is valid, and was successfully uploaded.\n";
    } else {
        echo "Possible file upload attack!\n";
    }

  }
}
