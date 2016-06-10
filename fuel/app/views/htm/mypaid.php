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
    <script src="/assets/js/analytics.js?ver=85"></script>
    <link rel="stylesheet" type="text/css" href="/assets/css/basic.css?ver=85" />
    <link rel="stylesheet" href="/assets/css/pc.css?ver=85" media="only screen and (min-width : 711px)">
    <link rel="stylesheet" href="/assets/css/sp.css?ver=85" media="only screen and (max-width : 710px)">
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
<tr><td class="td_49">所持ポイント</td><td class="td_49" id="point"></td></tr>
</table>

<table id="cel"></table>
</div>
<script src="/assets/js/basic.js?ver=85"></script>
<script src="/assets/js/check_news.js?ver=85"></script>
<script src="/assets/js/mypaid.js?ver=85"></script>
<script>
  $(function(){ ga('send', 'pageview'); });
</script>
</body>
</html>