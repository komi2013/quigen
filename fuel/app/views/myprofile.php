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
    <script src="/assets/js/analytics.js?ver=90"></script>
    <link rel="stylesheet" type="text/css" href="/assets/css/basic.css?ver=90" />
    <link rel="stylesheet" href="/assets/css/pc.css?ver=90" media="only screen and (min-width : 711px)">
    <link rel="stylesheet" href="/assets/css/sp.css?ver=90" media="only screen and (max-width : 710px)">
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
  <td><a href="/follower/?u=<?=$u_id?>"><img src="/assets/img/icon/people.png" class="icon"></a></td>
  <td class="td_34" id="num_follower"><a href="/follower/?u=<?=$u_id?>"><?=$follower?></a></td>
  <td><a href="/following/?u=<?=$u_id?>"><img src="/assets/img/icon/star_1.png" class="icon"></a></td>
  <td class="td_34" id="num_following"><a href="/following/?u=<?=$u_id?>">0</a></td>
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

<?php if( !isset($_GET['list']) ){ ?>
  <table><tr>
    <td style="width:25%;text-align:center;"><img src="/assets/img/icon/answer.png" class="icon"></td>
    <td style="width:25%;text-align:center;background-color:#F5F5F5;"><a href="/myprofile/?list=quiz"><img src="/assets/img/icon/quiz_generator.png" class="icon"></a></td>
    <td style="width:25%;text-align:center;background-color:#F5F5F5;"><a href="/htm/follow/" rel="nofollow"><img src="/assets/img/icon/star_1.png" class="icon"></a></td>
    <td style="width:25%;text-align:center;background-color:#F5F5F5;"><a href="/htm/quest/" rel="nofollow"><img src="/assets/img/icon/ticket.png" class="icon"></a></td>
  </tr></table>
<?php }else{ ?>
  <table><tr>
    <td style="width:25%;text-align:center;background-color:#F5F5F5;"><a href="/myprofile/"><img src="/assets/img/icon/answer.png" class="icon"></a></td>
    <td style="width:25%;text-align:center;"><img src="/assets/img/icon/quiz_generator.png" class="icon"></td>
    <td style="width:25%;text-align:center;background-color:#F5F5F5;"><a href="/htm/follow/" rel="nofollow"><img src="/assets/img/icon/star_1.png" class="icon"></a></td>
    <td style="width:25%;text-align:center;background-color:#F5F5F5;"><a href="/htm/quest/" rel="nofollow"><img src="/assets/img/icon/ticket.png" class="icon"></a></td>
  </tr></table>
<?php } ?>
<table id="cel"></table>
</div>
<div id="ad_right"></div>

<script>
  var u_id = '<?=$u_id?>';
  var csrf = '<?=Model_Csrf::setcsrf()?>';
</script>
<script src="/assets/js/basic.js?ver=90"></script>
<script src="/assets/js/check_news.js?ver=90"></script>
<script src="/assets/js/myprofile.js?ver=90"></script>
<script>
  $(function(){ ga('send', 'pageview'); });
</script>
</body>
</html>

