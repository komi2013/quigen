<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8" />
    <title>購入したクイズ</title>
    <link rel="shortcut icon" href="/assets/img/icon/quiz_generator.png" />
    <meta name="robots" content="noindex">
    <script src="/third/jquery-2.1.1.min.js"></script>
    <script src="/third/jquery.cookie.js"></script>
    <script>var ua = '<?=Config::get("my.ua")?>';</script>
    <script src="/assets/js/analytics.js?ver=48"></script>
    <link rel="stylesheet" type="text/css" href="/assets/css/basic.css?ver=48" />
    <link rel="stylesheet" href="/assets/css/pc.css?ver=48" media="only screen and (min-width : 711px)">
    <link rel="stylesheet" href="/assets/css/sp.css?ver=48" media="only screen and (max-width : 710px)">
    <meta name="viewport" content="width=device-width, user-scalable=no" >
  </head>
<body>

<table cellspacing="0" boroder="0" id="header">
  <td class="edge"><img src="/assets/img/icon/menu.png" alt="menu" class="icon" id="menu"></td>
  <td id="center"><h1 class="font_8 unread">購入したクイズ</h1></td>
  <td class="edge"></td>
</table>
<?php
  $side = View::forge('side');
  $side->this_page = '';
  echo $side;
?>
<div id="content">
<table>
<tr><td class="td_49">所持ポイント</td><td class="td_49" id="point"></td></tr>
</table>

<table id="cel"></table>
</div>
<script src="/assets/js/basic.js?ver=48"></script>
<script src="/assets/js/check_news.js?ver=48"></script>
<script src="/assets/js/mypaid.js?ver=48"></script>
<script>
  ga('send', 'pageview');
</script>
</body>
</html>