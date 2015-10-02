<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8" />
    <title>500 error</title>
    <link rel="shortcut icon" href="/assets/img/icon/quiz_generator.png" />
    <script src="/third/jquery-2.1.1.min.js"></script>
    <script src="/third/jquery.cookie.js"></script>
    <script>var ua = '<?=Config::get("my.ua")?>';</script>
    <script src="/assets/js/analytics.js?ver=34"></script>
    <link rel="stylesheet" type="text/css" href="/assets/css/basic.css?ver=34" />
    <link rel="stylesheet" href="/assets/css/pc.css?ver=34" media="only screen and (min-width : 711px)">
    <link rel="stylesheet" href="/assets/css/sp.css?ver=34" media="only screen and (max-width : 710px)">
    <meta name="viewport" content="width=device-width, user-scalable=no" >
  </head>
<body>

<table cellspacing="0" boroder="0" id="header">
  <td class="edge"><img src="/assets/img/icon/menu.png" alt="menu" class="icon" id="menu"></td>
  <td id="center" class="font_8 unread">500 error</td>
  <td class="edge"></td>
</table>
<?php
  $side = View::forge('side');
  $side->this_page = '';
  echo $side;
?>
<div id="content">
<h1>500 error</h1>
</div>
<script src="/assets/js/check_news.js?ver=34"></script>
<script src="/assets/js/basic.js?ver=34"></script>

<script>
  ga('send', 'pageview', location.pathname + location.search + location.hash +':500');
</script>
</body>
</html>