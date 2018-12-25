<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8" />
    <title>mypage</title>
    <link rel="shortcut icon" href="/assets/img/icon/quiz_generator.png" />
    <meta name="robots" content="noindex">
    <script src="/third/jquery-2.1.1.min.js"></script>
    <script src="/third/jquery.cookie.js"></script>
    <script>var ua = '<?=Config::get("my.ua")?>';</script>
    <script src="/assets/js/analytics.js<?=Config::get("my.cache_v")?>"></script>
    <link rel="stylesheet" type="text/css" href="/assets/css/basic.css<?=Config::get("my.cache_v")?>" />
    <link rel="stylesheet" href="/assets/css/pc.css<?=Config::get("my.cache_v")?>" media="only screen and (min-width : 711px)">
    <link rel="stylesheet" href="/assets/css/sp.css<?=Config::get("my.cache_v")?>" media="only screen and (max-width : 710px)">
    <meta name="viewport" content="width=device-width, user-scalable=no" >
  </head>
<body>

<?php 
  $side = View::forge('side');
  $side->this_page = 'myprofile';
  echo $side;
?>

<div id="content">
<div class="img_input">
  <span id="photo_res"><img src="/assets/img/icon/camera.png" id="photo" class="icon"></span>
  <input type="text" placeholder="name" maxlength="12" id="myname" class="input_with" value="<?=$myname?>">
</div>

<div style="text-align:center;width:100%;">
<?php if($introduce){ ?>
  <textarea maxlength="120" id="introduce" class="txt_long"><?=$introduce?></textarea>
<?php }else{ ?>
  <textarea placeholder="introduce.." maxlength="120" id="introduce" class="txt_long"></textarea>
<?php } ?>
</div>

<table>
  <tr>
    <td style="width:20%;">
      <img src="/assets/img/icon/fb.jpg" alt="facebook" class="icon auth" data-url="<?=$fb_url?>">
    </td>
    <td style="width:20%">
      <img src="/assets/img/icon/tw.jpg" alt="twitter" class="icon auth" data-url="/twoauth/">
    </td>
    <td style="width:20%;">
      <img src="/assets/img/icon/gp.png" alt="google plus" class="icon auth" data-url="<?=$gp_url?>">
    </td>
    <td style="width:20%;"><img src="/assets/img/icon/power_0.png" id="del_cookie" class="icon"></td>
    <td style="width:20%;">
      <img src="/assets/img/icon/upload_0.png" alt="generate" class="icon" id="generate">
      <img src="/assets/img/icon/success.png" alt="success" class="icon" id="success" style="display:none;">
      <img src="/assets/img/icon/cross_big.png" alt="success" class="icon" id="delete" style="display:none;">
    </td>
  </tr>
</table>

<table>
<tr>
  <td> <a href="/follower/?u=<?=$u_id?>">
    <span class="icon_num"><?=$follower?></span>
    <img src="/assets/img/icon/people.png" class="icon">
  </a> </td>
  <td> <a href="/following/?u=<?=$u_id?>">
    <span class="icon_num" id="num_following">0</span>
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

<table id="rank"></table>

<table>
<tr>
  <td><img src="/assets/img/icon/circle_big.png" class="icon"></td>
  <td class="td_34" id="num_ratio">0 % </td>
  <td><img src="/assets/img/icon/answer.png" class="icon"></td>
  <td class="td_34" id="num_answer">0</td>
</tr>
</table>

<table>
<tr>
<td style="width:25%;">
  <a href="<?=$profile_fb_url?>" target="_blank">
    <img src="/assets/img/icon/fb.jpg" alt="facebook" class="icon">
  </a>
</td>
<td style="width:25%;">
  <a href="<?=$profile_tw_url?>" target="_blank">
    <img src="/assets/img/icon/tw.jpg" alt="twitter" class="icon">
  </a>
</td>
<td style="width:25%;">
  <a href="<?=$profile_ln_url?>" target="_blank" class="pc_disp_none">
    <img src="/assets/img/icon/ln.jpg" alt="line" class="icon">
  </a>
</td>
<td style="width:25%;">
  <a href="<?=$profile_clip_url?>" target="_blank">
    <img src="/assets/img/icon/clip.png" alt="clip" class="icon">
  </a>
</td>
</tr>
</table>

<div id="ad"><iframe src="/htm/ad_blank/" width="320" height="50" frameborder="0" scrolling="no"></iframe></div>
<table>
  <tr>
  <td class="<?= $list == '' ? 'this_page' : 'another_page' ?>"> <a href="/myprofile/">
    <img src="/assets/img/icon/answer.png" class="icon">
  </a> </td>
  <td class="<?= $list == 'graph' ? 'this_page' : 'another_page' ?>"> <a href="/myprofile/?list=graph">
    <img src="/assets/img/icon/bar-chart.png" class="icon">
  </a> </td>
  <td class="<?= $list == 'forum' ? 'this_page' : 'another_page' ?>"> <a href="/myprofile/?list=forum">
    <span class="icon_num"><?=$amt_forum?></span>
    <img src="/assets/img/icon/list.png" class="icon">
  </a> </td>
  <td class="<?= $list == 'msg' ? 'this_page' : 'another_page' ?>"> <a href="/myprofile/?list=msg">
    <img src="/assets/img/icon/chat.png" class="icon">
  </a> </td>
  </tr>
</table>

<?php foreach($arr_list as $d ){?>
<div class="div_t">
  <?php if( $d['img']){?>
    <img src="<?=$d['img']?>" class="icon">
  <?php }?>
  <?=$d['txt']?>
  <?php if( $d['no_param'] == 0 ){?>
  &nbsp; &nbsp; <a href="/forum/?f=<?=$d['forum_id']?>"> >> </a>
  <?php }?>
  <div style="width:100%;text-align:right;"><?=$d['open_time']?></div>
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

<?php foreach($msg_usr as $d ){?>
<a href="/profile/?u=<?=$d['usr_id']?>&list=msg"><img src="<?=$d['u_img']?>" class="icon" style="padding:20px;"></a>
<?php } ?>

<table id="cel"></table>

</div>
<div id="ad_right"></div>

<script>
  var u_id = '<?=$u_id?>';
  var csrf = '<?=Model_Csrf::setcsrf()?>';
  var del = '<?=Config::get("lang.delete")?>';
  var no_ = '<?=Config::get("lang.no_")?>';
  var mon = '<?=Config::get("lang.mon")?>';
  var please_logout = '<?=Config::get("lang.please_logout")?>';
  var checked_mypage = '<?=Config::get("lang.checked_mypage")?>';
  var login = '<?=Config::get("lang.login")?>';
  var answer_first = '<?=Config::get("lang.answer_first")?>';
  var change_profile = '<?=Config::get("lang.change_profile")?>';
  var logout = '<?=Config::get("lang.logout")?>';
  var tag_category = '<?=Config::get("lang.tag_category")?>';
</script>
<script src="/assets/js/basic.js<?=Config::get("my.cache_v")?>"></script>
<script src="/assets/js/check_news.js<?=Config::get("my.cache_v")?>"></script>
<script src="/assets/js/myprofile.js<?=Config::get("my.cache_v")?>"></script>
<script>
  $(function(){ ga('send', 'pageview'); });
</script>

</body>

</html>

