<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8" />
    <title>php error</title>
    <link rel="shortcut icon" href="/assets/img/icon/quiz_generator.png">
    <script src="/third/jquery-2.1.1.min.js"></script>
    <script src="/third/jquery.cookie.js"></script>
    <link rel="stylesheet" type="text/css" href="/assets/css/basic.css?ver=78" />
    <link rel="stylesheet" href="/assets/css/pc.css?ver=78" media="only screen and (min-width : 711px)">
    <link rel="stylesheet" href="/assets/css/sp.css?ver=78" media="only screen and (max-width : 710px)">
    <meta name="viewport" content="width=device-width, user-scalable=no" >
    <script>var ua = '<?=Config::get("my.ua")?>';</script>
    <script src="/assets/js/analytics.js?ver=78"></script>
  </head>
<body>
<table cellspacing="0" boroder="0" id="header">
  <td class="edge"><img src="/assets/img/icon/menu.png" alt="menu" class="icon" id="menu"></td>
  <td id="center">php error</td>
  <td class="edge" id="right"></td>
</table>
<?php
  $side = View::forge('side');
  $side->this_page = '';
  echo $side;
?>
<div id="content">
  <h1>php error</h1>
</div>
<?php Model_Log::warn('php error');?>    
<script src="/assets/js/basic.js?ver=78"></script>
<script>
  ga('send', 'pageview', location.pathname + location.search + location.hash +':php_error');
</script>
</body>
</html>