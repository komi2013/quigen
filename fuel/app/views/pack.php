<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8" />
    <title><?=$pack[0]['txt']?></title>
    <meta name="robots" content="noindex">
    <link rel="shortcut icon" href="/assets/img/icon/quiz_generator.png">
    <script src="/third/jquery-2.1.1.min.js"></script>
    <script src="/third/jquery.cookie.js"></script>
    <script>var ua = '<?=Config::get("my.ua")?>';</script>
    <script src="/assets/js/analytics.js?ver=30"></script>
    <meta property="og:title" content="<?=$pack[0]['txt']?>" />
    <meta property="og:url" content="http://<?=Config::get('my.domain').'/pack/?p='.$_GET['p']?>" />
    <meta property="og:image" content="http://<?=Config::get('my.domain')?>/assets/img/icon/qg_big.png" />
    <meta property="og:description" content="<?=$pack[0]['txt']?>" />
    <link rel="stylesheet" type="text/css" href="/assets/css/basic.css?ver=30" />
    <link rel="stylesheet" href="/assets/css/pc.css?ver=30" media="only screen and (min-width : 711px)">
    <link rel="stylesheet" href="/assets/css/sp.css?ver=30" media="only screen and (max-width : 710px)">
    <meta name="viewport" content="width=device-width, user-scalable=no" >
  </head>
<body>
<link rel="stylesheet" type="text/css" href="/assets/css/profile.css?ver=30" />

<table cellspacing="0" boroder="0" id="header">
  <td class="edge"><img src="/assets/img/icon/menu.png" alt="menu" class="icon" id="menu"></td>
  <td id="center"><h1 class="font_8 unread">パック</h1></td>
  <td class="edge" id="right">
  </td>
</table>
<?php
  $side = View::forge('side');
  $side->this_page = '';
  echo $side;
?>
<div id="content">
<?= View::forge('ad_load') ?>
<table id="cel"></table>
</div>
<script> var pack_id = '<?=$_GET["p"]?>'; </script>
<script src="/assets/js/basic.js?ver=30"></script>
<script src="/assets/js/check_news.js?ver=30"></script>
<script src="/assets/js/pack.js?ver=30"></script>
</body>
</html>

