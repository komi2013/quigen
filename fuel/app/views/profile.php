<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8" />
    <title><?=$usr_name?></title>
<?php if( $seo_index ){ ?>
    <meta name="description" content="<?=$meta_description?>, <?=$follower?> follower, <?=$following?> following user">
    <link rel="canonical" href="http://<?=Config::get('my.domain').'/profile/?u='.$_GET['u']?>" />
<?php } else { ?>
    <meta name="robots" content="noindex,follow">
<?php } ?>
    <link rel="shortcut icon" href="/assets/img/icon/quiz_generator.png">
    <script src="/third/jquery-2.1.1.min.js"></script>
    <script src="/third/jquery.cookie.js"></script>
    <meta property="og:image" content="http://<?=Config::get('my.domain').$usr_img?>" />
    <script>var ua = '<?=Config::get("my.ua")?>';</script>
    <script src="/assets/js/analytics.js?ver=96"></script>
    <link rel="stylesheet" type="text/css" href="/assets/css/basic.css?ver=96" />
    <link rel="stylesheet" href="/assets/css/pc.css?ver=96" media="only screen and (min-width : 711px)">
    <link rel="stylesheet" href="/assets/css/sp.css?ver=96" media="only screen and (max-width : 710px)">
    <meta name="viewport" content="width=device-width, user-scalable=no" >
  </head>
<body>

<?php
  $side = View::forge('side');
  $side->this_page = '';
  echo $side;
?>
<div id="content">
<table>
  <tr>
  　<td id="photo_res"><img src="<?=$usr_img?>" class="icon" id="photo" <?=$css?> ></td>
  　<td id="name"><h1><?=$usr_name?></h1></td>
    <td>
      <span id="right">
        <img id="following1" src="/assets/img/icon/hourglass.png" class="icon" style="display:none;">
        <img id="following2" src="/assets/img/icon/star_1.png" class="icon" style="display:none;">
        <img id="following0" src="/assets/img/icon/star_0.png" class="icon" style="display:none;">
      </span>
    </td>
  </tr>
  <tr><td colspan="3" id="introduce" class="txt_long"><?=$introduce?></td></tr>
</table>

<?php if( !isset($_GET['list']) ){ ?>
<table style="border-collapse: collapse;">
<tr>
  <td class="td_68_c" style="text-align: center;">tag category</td>
  <td class="td_15"><img src="/assets/img/icon/circle_big.png" class="icon"></td>
  <td class="td_15"><img src="/assets/img/icon/ranking.png" class="icon"></td>
</tr>
<?php if( isset($rank) ){ $i = 0; foreach($rank as $k => $d){  if($i < 5){ ?>
<tr>
  <td class="td_68_c"><a href="/search/?tag=<?=$d['url_tag']?>"><?=$d['tag']?></a></td>
  <td class="td_15"><?=$d['cnt']?></td>
  <td class="td_15"><?=$d['rank']?></td>
</tr>
<?php ++$i; } } } ?>
</table>
<?php } ?>
<table cellspacing="1" boroder="0">
<tr>
  <td> <a href="/follower/?u=<?=$usr_id?>">
    <span class="icon_num"><?=$follower?></span>
    <img src="/assets/img/icon/people.png" class="icon">
  </a> </td>
  <td> <a href="/following/?u=<?=$usr_id?>">
    <span class="icon_num"><?=$following?></span>
    <img src="/assets/img/icon/star_1.png" class="icon">
  </a> </td>
  <td>
    <span class="icon_num"><?=$nice?></span>
    <img src="/assets/img/icon/thumbup_1.png" class="icon">
  </td>
  <td>
    <span class="icon_num"><?=$certify?></span>
    <img src="/assets/img/icon/medal_1.png" class="icon">
  </td>
</tr>
</table>

<table cellspacing="1" boroder="0">
<tr>
<td style="width:70px;">
  <a href="<?=$fb_url?>" target="_blank">
    <img src="/assets/img/icon/fb.jpg" alt="facebook" class="icon">
  </a>
</td>
<td style="width:70px;">
  <a href="<?=$tw_url?>" target="_blank">
  <img src="/assets/img/icon/tw.jpg" alt="twitter" class="icon">
  </a>
</td>
<td style="width:70px;" class="pc_disp_none">
  <a href="<?=$ln_url?>" target="_blank">
  <img src="/assets/img/icon/ln.jpg" alt="line" class="icon">
  </a>
</td>
<td style="width:70px;">
  <a href="<?=$clip_url?>" target="_blank">
  <img src="/assets/img/icon/clip.png" alt="clip" class="icon">
  </a>
</td>
</tr>
</table>

<div id="ad"><iframe src="/htm/ad_blank/" width="320" height="50" frameborder="0" scrolling="no"></iframe></div>
<table>
  <tr>
  <td class="<?= $list == '' ? 'this_page' : 'another_page' ?>"> <a href="/profile/?u=<?=$_GET['u']?>">
    <span class="icon_num"><?=$amt_answer?></span>
    <img src="/assets/img/icon/answer.png" class="icon">
  </a> </td>
  <td class="<?= $list == 'graph' ? 'this_page' : 'another_page' ?>"> <a href="/profile/?u=<?=$_GET['u']?>&list=graph">
    <img src="/assets/img/icon/bar-chart.png" class="icon">
  </a> </td>
  <td class="<?= $list == 'forum' ? 'this_page' : 'another_page' ?>"> <a href="/profile/?u=<?=$_GET['u']?>&list=forum">
    <span class="icon_num"><?=$amt_forum?></span>
    <img src="/assets/img/icon/list.png" class="icon">
  </a> </td>
  <td class="<?= $list == 'msg' ? 'this_page' : 'another_page' ?>"> <a href="/profile/?u=<?=$_GET['u']?>&list=msg">
    <img src="/assets/img/icon/chat.png" class="icon">
  </a> </td>
  </tr>
</table>

<?php foreach($arr_list as $d ){?>
<div class="div_t" > 
  <?php if( $d['img']){?>
    <img src="<?=$d['img']?>" class="icon">
  <?php }?>
  <?=$d['txt']?>
  <?php if( $d['no_param'] == 0 ){?>
  &nbsp; &nbsp; <a href="/forum/?f=<?=$d['forum_id']?>"> >> </a>
  <?php }?>
  <div style="width:100%;text-align:right;"> <?=$d['open_time']?></div>
</div>
<?php } ?>

<?php foreach($day as $d ){?>
<div class="graph_frame">
  <div class="graph_date"><?=$d['day']?></div>
  <?php if($d['answer']){?>
  <div class="graph_txt"><?=$d['answer']?>answer, spend <?=$d['time']?></div>
  <?php }?>
</div>
<div class="graph_bar" style="width:<?= round($d['answer']/$max * 100)  ?>%;">&nbsp;</div>
<?php } ?>
<?php if($list == 'msg'){ ?>
<script src="/third/img-touch-canvas_1.js?ver=96"></script>
<div class="forum_form" id="txt" contenteditable="true"></div>
<table><tr>
  <td class="td_33">
    <input type="file" id="file_load" >
    <img src="/assets/img/icon/camera.png" class="icon" id="camera">
  </td>
  <td class="td_33"><img src="/assets/img/icon/happy.png" class="icon" id="emoji_show"></td>
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

<div id="canvas_div_img" style="text-align:center;">

<canvas id="mycanvas1" height="300" width="300"></canvas>
</div>
<div id="emoji_list" style="display:none;">
  <?php foreach(Model_Emoji::$table as $k => $d){ ?>
    <?=$d?>
  <?php } ?>
</div>
<script src="/assets/js/message.js?ver=96"></script>
<?php } ?>

<?php foreach($msg_list as $d ){?>
  <?php if($d['sender'] == $u_id){ ?>
  <div class="my_img"><img src="<?=$d['img']?>"></div>
  <div class="my_msg"><?=$d['txt']?> <div style="width:100%;text-align:right;"><?=$d['create_at']?></div></div>
  <?php } else { ?>
  <div class="other_img"><img src="<?=$d['img']?>"></div>
  <div class="other_msg"><img src="<?=$d['u_img']?>" class="icon"><?=$d['txt']?>
    <div><?=$d['create_at']?></div>
  </div>
  <?php } ?>
<?php } ?>

<table id="cel"></table>

</div>
<script>
  var receiver = '<?=$usr_id?>'; 
  var u_id = '<?=$u_id?>';
  var status = '<?=$status?>';
  var list = '<?=$list?>';
  var csrf = '<?=Model_Csrf::setcsrf()?>';
</script>
<script src="/assets/js/basic.js?ver=96"></script>
<script src="/assets/js/check_news.js?ver=96"></script>
<script src="/assets/js/profile.js?ver=96"></script>
<script>
  $(function(){ ga('send', 'pageview'); });
</script>
</body>
</html>



