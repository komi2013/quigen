<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8" />
    <title>フォロー</title>
    <link rel="shortcut icon" href="/assets/img/icon/quiz_generator.png" />
    <meta name="robots" content="noindex">
    <script src="/third/jquery-2.1.1.min.js"></script>
    <script src="/third/jquery.cookie.js"></script>
    <script>var ua = '<?=Config::get("my.ua")?>';</script>
    <script src="/assets/js/analytics.js?ver=30"></script>
    <link rel="stylesheet" type="text/css" href="/assets/css/basic.css?ver=30" />
    <link rel="stylesheet" href="/assets/css/pc.css?ver=30" media="only screen and (min-width : 711px)">
    <link rel="stylesheet" href="/assets/css/sp.css?ver=30" media="only screen and (max-width : 710px)">
    <meta name="viewport" content="width=device-width, user-scalable=no" >
  </head>
<body>

<table cellspacing="0" boroder="0" id="header">
  <td class="edge"><img src="/assets/img/icon/menu.png" alt="menu" class="icon" id="menu"></td>
  <td id="center"><h1 class="font_8 unread">フォロー</h1></td>
  <td class="edge"></td>
</table>
<?php
  $side = View::forge('side');
  $side->this_page = 'follow';
  echo $side;
?>
<div id="content">
<?= View::forge('ad_load') ?>
<table id="cel"></table>
</div>
<script src="/assets/js/check_news.js?ver=30"></script>
<script src="/assets/js/basic.js?ver=30"></script>
<script src="/assets/js/follow.js?ver=30"></script>
</body>
</html>