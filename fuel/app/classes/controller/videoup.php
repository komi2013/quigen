<?php
class Controller_Videoup extends Controller
{
  public function action_index()
  {
    @mkdir(DOCROOT.'assets/video/'.date('Ymd'), 0777);
    @chmod(DOCROOT.'assets/video/'.date('Ymd'), 0777);

//    fd.append('room', roomName);
//    fd.append('media', 'audio');
//    fd.append('u_id', localStorage.ua_u_id);
//    fd.append('split', splitAudio);
    
    $uploadfile = DOCROOT.'assets/video/'.date('Ymd').'/'.
            $_POST['room'].'_'.$_POST['media'].'_'.$_POST['u_id'].'_'.$_POST['split'].'.webm';
    if ( move_uploaded_file($_FILES['data']['tmp_name'], $uploadfile) ) {
        echo "File is valid, and was successfully uploaded.\n";
    } else {
        echo "Possible file upload attack!\n";
    }
  }
  public function action_dir(){
	// ディレクトリのパス
	$dir = DOCROOT.'assets/video/' ;

	$check_dirs = [ $dir ] ;
	$file_paths = [] ;

	while( $check_dirs ) {
		$dir_path = $check_dirs[0] ;
//echo $dir_path;
		if( is_dir ( $dir_path ) && $handle = opendir ( $dir_path ) ) {
			while( ( $file = readdir ( $handle ) ) !== false ) {
				if( in_array ( $file, [ ".", ".." ] ) !== false ) continue ;
				$path = rtrim ( $dir_path, "/" ) . "/" . $file ;

				if ( filetype ( $path ) === "dir" ) {
					$check_dirs[] = $path ;
				} else {
//					echo $file.'<br>';
//					echo $path.'<br>';
				}
//                        					echo @$file.'<br>';
					
                            $content = str_replace(DOCROOT, "", $path);
                            echo '<a href="/'.$content.'">'.$content.'</a><br>';
			}
		}

		array_shift( $check_dirs ) ;
	}
//    echo 'morai';
  }
}
