<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8" />
    <title>マイプロファイル</title>
    <link rel="shortcut icon" href="/assets/img/icon/quiz_generator.png" />
    <meta name="robots" content="noindex">
    <script src="/third/jquery-2.1.1.min.js"></script>
    <script src="/third/jquery.cookie.js"></script>
    <script>var ua = '<?=Config::get("my.ua")?>';</script>
    <script src="/assets/js/analytics.js?ver=62"></script>
    <link rel="stylesheet" type="text/css" href="/assets/css/basic.css?ver=62" />
    <link rel="stylesheet" href="/assets/css/pc.css?ver=62" media="only screen and (min-width : 711px)">
    <link rel="stylesheet" href="/assets/css/sp.css?ver=62" media="only screen and (max-width : 710px)">
    <meta name="viewport" content="width=device-width, user-scalable=no" >
  </head>
<body>
<table cellspacing="0" boroder="0" id="header">
  <td class="edge"><img src="/assets/img/icon/menu.png" alt="menu" class="icon" id="menu"></td>
  <td id="center"><h1 class="font_8 unread">マイプロファイル</h1></td>
  <td class="edge">
    <img src="/assets/img/icon/upload_0.png" alt="generate" class="icon" id="generate">
    <img src="/assets/img/icon/success.png" alt="success" class="icon" id="success" style="display:none;">
    <img src="/assets/img/icon/cross_big.png" alt="success" class="icon" id="delete" style="display:none;">
  </td>
</table>
<?php
  $side = View::forge('side');
  $side->this_page = 'myprofile';
  echo $side;
?>

<div id="content">
<table>
  <tr>
    <td id="photo_res"><img src="/assets/img/icon/camera.png" id="photo" class="icon"></td>
    <td id="name"><input type="text" placeholder="name" maxlength="12" id="myname" class="txt_99"></td>
    <td><a href="#" id="del_cookie"><img src="/assets/img/icon/power.png" class="icon"></a></td>
  </tr>
  <tr><td colspan="3" style="text-align:center;">
    <?php if(isset($introduce) AND $introduce != ''){ ?>
      <textarea maxlength="120" id="introduce" class="txt_long"><?=$introduce?></textarea>
    <?php }else{ ?>
      <textarea placeholder="自己紹介" maxlength="120" id="introduce" class="txt_long"></textarea>
    <?php } ?>
  </td></tr>
</table>


<table>
<tr>
  <td><a href="/follower/?u=<?=$u_id?>"><img src="/assets/img/icon/people.png" class="icon"></a></td>
  <td class="num_txt" id="num_follower"><a href="/follower/?u=<?=$u_id?>"><?=$follower?></a></td>
  <td><a href="/following/?u=<?=$u_id?>"><img src="/assets/img/icon/star_1.png" class="icon"></a></td>
  <td class="num_txt" id="num_following"><a href="/following/?u=<?=$u_id?>">0</a></td>
</tr>
</table>
<table cellspacing="1" boroder="0" id="sns">
<tr>
<td style="width:33%;">
  <a href="#"><img src="/assets/img/icon/fb.jpg" alt="facebook" class="icon auth" data-url="<?=$fb_url?>"></a>
</td>
<td style="width:33%">
  <a href="#"><img src="/assets/img/icon/tw.jpg" alt="twitter" class="icon auth" data-url="/twoauth/"></a>
</td>
<td style="width:33%;">
  <a href="#"><img src="/assets/img/icon/gp.png" alt="google plus" class="icon auth" data-url="<?=$gp_url?>"></a>
</td>
</tr>
</table>

<?= View::forge('htm/ad_load') ?>
<table id="cel"></table>
</div>
<?= View::forge('htm/ad_load_right') ?>

<script>
  var u_id = '<?=$u_id?>';
  var csrf = '<?=Model_Csrf::setcsrf()?>';
</script>
<script src="/assets/js/basic.js?ver=62"></script>
<script src="/assets/js/check_news.js?ver=62"></script>
<script src="/assets/js/myprofile.js?ver=62"></script>
<script>
  ga('send', 'pageview');
</script>
</body>
</html>

