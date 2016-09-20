<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8" />
    <title>php short</title>
    <link rel="shortcut icon" href="/assets/img/icon/quiz_generator.png">
    <script src="/third/jquery-2.1.1.min.js"></script>
    <script src="/third/jquery.cookie.js"></script>
    <link rel="stylesheet" type="text/css" href="/assets/css/basic.css?ver=95" />
    <link rel="stylesheet" href="/assets/css/pc.css?ver=95" media="only screen and (min-width : 711px)">
    <link rel="stylesheet" href="/assets/css/sp.css?ver=95" media="only screen and (max-width : 710px)">
    <meta name="viewport" content="width=device-width, user-scalable=no" >
    <script>var ua = '<?=Config::get("my.ua")?>';</script>
    <script src="/assets/js/analytics.js?ver=95"></script>
  </head>
<body>
<?php
  $side = View::forge('side');
  $side->this_page = '';
  echo $side;
?>
<div id="content">
  <h1>php short</h1>
</div>
<?php Model_Log::warn('php short');?>
<script src="/assets/js/basic.js?ver=95"></script>
<script>
  ga('send', 'pageview', location.pathname + location.search + location.hash +':php_short');
</script>
</body>
</html>