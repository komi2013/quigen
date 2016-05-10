<?php header("HTTP/1.0 404 Not Found"); ?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8" />
    <title>Not Found</title>
    <link rel="shortcut icon" href="/assets/img/icon/quiz_generator.png" />
    <script src="/third/jquery-2.1.1.min.js"></script>
    <script src="/third/jquery.cookie.js"></script>
    <script>var ua = '<?=Config::get("my.ua")?>';</script>
    <script src="/assets/js/analytics.js?ver=69"></script>
    <link rel="stylesheet" type="text/css" href="/assets/css/basic.css?ver=69" />
    <link rel="stylesheet" href="/assets/css/pc.css?ver=69" media="only screen and (min-width : 711px)">
    <link rel="stylesheet" href="/assets/css/sp.css?ver=69" media="only screen and (max-width : 710px)">
    <meta name="viewport" content="width=device-width, user-scalable=no" >
  </head>
<body>
<table cellspacing="0" boroder="0" id="header">
  <td class="edge"><img src="/assets/img/icon/menu.png" alt="menu" class="icon" id="menu"></td>
  <td id="center" class="font_8 unread">Not Found</td>
  <td class="edge"></td>
</table>
<?php
  $side = View::forge('side');
  $side->this_page = '';
  echo $side;
?>
<div id="content">

<h1>Not Found</h1>
<div id="ad"></div>
</div>

<div id="ad_right"></div>

<script src="/assets/js/check_news.js?ver=69"></script>
<script src="/assets/js/basic.js?ver=69"></script>
<?php Model_Log::warn('Not Found');?>
<script>
  $(function(){ ga('send', 'pageview', location.pathname + location.search + location.hash +':404'); });
</script>
</body>
</html>
