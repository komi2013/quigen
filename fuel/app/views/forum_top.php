<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8" />
    <title><?=Config::get('my.forum_list_title')?></title>
    <meta name="description" content="<?=Config::get("my.forum_list_description")?>">
    <link rel="shortcut icon" href="/assets/img/icon/quiz_generator.png" />
<?php if( isset($top) ){  ?>    
    <link rel="canonical" href="http://<?=Config::get('my.domain').'/forumlist/'?>" />
<?php } ?>
<?php if( isset($_GET['page']) ){ ?>
    <meta name="robots" content="noindex,follow">
<?php } ?>
    <script src="/third/jquery-2.1.1.min.js"></script>
    <script src="/third/jquery.cookie.js"></script>
    <script>var ua = '<?=Config::get("my.ua")?>';</script>
    <script src="/assets/js/analytics.js?ver=96"></script>
    <link rel="stylesheet" type="text/css" href="/assets/css/basic.css?ver=96" />
    <link rel="stylesheet" href="/assets/css/pc.css?ver=96" media="only screen and (min-width : 711px)">
    <link rel="stylesheet" href="/assets/css/sp.css?ver=96" media="only screen and (max-width : 710px)">
    <meta name="viewport" content="width=device-width, user-scalable=no" >
  </head>
<body>
<script src="/third/img-touch-canvas_1.js?ver=96"></script>

<?php
  $side = View::forge('side');
  $side->this_page = 'forumlist';
  echo $side;
?>

<div id="content">
<div style="margin: 10px;">
<?=Config::get("my.forum_list_description")?>
</div>
<?php $arr_forum = []; foreach($forum as $k => $d){ ?>
<a href="/forum/?f=<?=$d['id']?>" id="q_id_<?=$d['id']?>">
<div style="background-image:url(<?=$d['img']?>);" class="img_frame">
  <div class="img_frame_top"></div>
  <div class="img_frame_bottom">
    <div class="img_frame_txt"><?=Str::truncate(Security::htmlentities($d['txt']), 80)?></div>  
  </div>  
</div>
</a>
<?php $arr_forum[] = $d['id']; } ?>
<?php if( isset($top) AND $page > 2) {?>
<table>
  <tr>
  <td class="td_33">
    <?php if(!isset($top)){ ?>
    <a href="/forumlist/?page=<?=$page+1?>"> << </a>
    <?php }?>
  </td>
  <td class="td_33">||</td>
  <td class="td_33">
    <?php if($page > 2){ ?>
    <a href="/forumlist/?page=<?=$page-1?>"> >> </a>
    <?php }?>
  </td>
  </tr>
</table>
<?php } ?>
<br>
<div id="input_form">
<table style="text-align:center;">
<tr><td><textarea placeholder="new topic" maxlength="400" class="txt_long_60" id="txt"></textarea></td></tr>
</table>

<table><tr>
  <td class="td_33">
    <input type="file" id="file_load" >
    <img src="/assets/img/icon/camera.png" class="icon">
  </td>
  <td class="td_33"></td>
  <td class="td_33">
    <img src="/assets/img/icon/upload_0.png" alt="submit" id="generate" class="icon">
    <img src="/assets/img/icon/success.png" alt="success" class="icon" id="success" style="display:none;">
  </td>
</tr></table>

<table style="display:none;" id="canvas_menu">
  <tr>
  <td id="rotate" style="width:50px;cursor:pointer;"><img src="/assets/img/icon/rotate.png" class="icon" alt="rotate"></td>
  <td id="minus" class="sp_disp_none" style="width:50px;cursor:pointer;"><img src="/assets/img/icon/minus.png" class="icon" alt="minus"></td>
  <td id="plus" class="sp_disp_none" style="width:50px;cursor:pointer;"><img src="/assets/img/icon/plus.png" class="icon" alt="plus"></td>
  <td class="sp_disp_none" style="width:50px;cursor:pointer;">
    <select name='scale' style="font-size:20px;">
        <option>1</option>
        <option>5</option>
        <option>10</option>
        <option>20</option>
        <option>40</option>
    </select>
  </td>
  </tr>
</table>
</div>
<div id="canvas_div_img" style="text-align:center;">

<canvas id="mycanvas1" height="300" width="300"></canvas>
</div>

<div id="ad"><iframe src="/htm/ad_blank/" width="320" height="50" frameborder="0" scrolling="no"></iframe></div>
<table>
  <tr><td class="td_99_c"><a href="https://www.youtube.com/watch?v=ZQlq1a-jPHw" target="_blank">how to use(video)</a></td></tr>
  <tr><td class="td_99_c"><a href="http://quizgenerator-help.hatenadiary.jp/archive/2015" target="_blank">how to use(blog)</a></td></tr>
  <tr><td class="td_99_c"><a href="/htm/rule/">rule</a></td></tr>
</table>

</div>

<div id="ad_right"></div>

<script>
  var arr_forum = JSON.parse( '<?= json_encode($arr_forum) ?>' );
  var u_id = '<?=$u_id?>';
  var csrf = '<?=Model_Csrf::setcsrf()?>';
</script>
<script src="/assets/js/check_news.js?ver=96"></script>
<script src="/assets/js/basic.js?ver=96"></script>
<script src="/assets/js/forum_list.js?ver=96"></script>
<script>
  $(function(){ ga('send', 'pageview'); });
</script>
</body>
</html>
