<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8" />
    <title>following</title>
    <meta name="robots" content="noindex">
    <link rel="shortcut icon" href="/assets/img/icon/quiz_generator.png" />
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
  $side->this_page = '';
  echo $side;
?>
<div id="content">
    <img src="<?=$usr_img?>" id="u_img" class="icon" <?=$css?> >
    <img src="/assets/img/icon/cross_big.png" id="delete" class="icon" style="display:none;">
    <img src="/assets/img/icon/success.png" id="success" class="icon" style="display:none;">
<div id="ad"><iframe src="/htm/ad_blank/" width="320" height="50" frameborder="0" scrolling="no"></iframe></div>
<table id="cel"></table>
</div>

<script>
  var sender = '<?=$sender?>';
  var csrf = '<?=Model_Csrf::setcsrf()?>';
  var del = '<?=Config::get("lang.delete")?>';
</script>
<script src="/assets/js/check_news.js<?=Config::get("my.cache_v")?>"></script>
<script src="/assets/js/basic.js<?=Config::get("my.cache_v")?>"></script>
<?php if($usr_id == $sender){ ?>
<script src="/assets/js/following_my.js<?=Config::get("my.cache_v")?>"></script>
<?php }else{ ?>
<script src="/assets/js/following.js<?=Config::get("my.cache_v")?>"></script>
<?php } ?>

<script>
  $(function(){ ga('send', 'pageview'); });
</script>

</body>
</html>

