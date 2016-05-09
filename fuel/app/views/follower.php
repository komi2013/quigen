<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8" />
    <title>フォロワー</title>
    <meta name="robots" content="noindex">
    <link rel="shortcut icon" href="/assets/img/icon/quiz_generator.png" />
    <script src="/third/jquery-2.1.1.min.js"></script>
    <script src="/third/jquery.cookie.js"></script>
    <script>var ua = '<?=Config::get("my.ua")?>';</script>
    <script src="/assets/js/analytics.js?ver=67"></script>
    <link rel="stylesheet" type="text/css" href="/assets/css/basic.css?ver=67" />
    <link rel="stylesheet" href="/assets/css/pc.css?ver=67" media="only screen and (min-width : 711px)">
    <link rel="stylesheet" href="/assets/css/sp.css?ver=67" media="only screen and (max-width : 710px)">
    <meta name="viewport" content="width=device-width, user-scalable=no" >
  </head>
<body>
<table cellspacing="0" boroder="0" id="header">
  <td class="edge"><img src="/assets/img/icon/menu.png" alt="menu" class="icon" id="menu"></td>
  <td id="center"><h1 class="font_8 unread">フォロワー</h1></td>
  <td class="edge">
    <img src="<?=$usr_img?>" id="u_img" class="icon" <?=$css?> >
    <img src="/assets/img/icon/cross_big.png" id="delete" class="icon" style="display:none;">
    <img src="/assets/img/icon/success_0.png" id="confirm" class="icon" style="display:none;">
    <img src="/assets/img/icon/success.png" id="success" class="icon" style="display:none;">
  </td>
</table>
<?php
  $side = View::forge('side');
  $side->this_page = '';
  echo $side;
?>

<div id="content">
<div id="ad"></div>
<table id="cel"></table>
</div>

<script>
  var receiver = '<?=$receiver?>';
  var csrf = '<?=Model_Csrf::setcsrf()?>';
</script>
<script src="/assets/js/check_news.js?ver=67"></script>
<script src="/assets/js/basic.js?ver=67"></script>
<?php if($usr_id == $receiver){ ?>
<script src="/assets/js/follower_my.js?ver=67"></script>
<?php }else{ ?>
<script src="/assets/js/follower.js?ver=67"></script>
<?php } ?>

<script>
  $(function(){ ga('send', 'pageview'); });
</script>

</body>
</html>
