<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8" />
    <title>news</title>
    <link rel="shortcut icon" href="/assets/img/icon/quiz_generator.png" />
    <meta name="robots" content="noindex">
    <script src="/third/jquery-2.1.1.min.js"></script>
    <script src="/third/jquery.cookie.js"></script>
    <script>var ua = '<?=Config::get("my.ua")?>';</script>
    <script src="/assets/js/analytics.js?ver=96"></script>
    <link rel="stylesheet" type="text/css" href="/assets/css/basic.css?ver=96" />
    <link rel="stylesheet" href="/assets/css/pc.css?ver=96" media="only screen and (min-width : 711px)">
    <link rel="stylesheet" href="/assets/css/sp.css?ver=96" media="only screen and (max-width : 710px)">
    <meta name="viewport" content="width=device-width, user-scalable=no" >
  </head>
<body>

<?php
  $side = View::forge('side');
  $side->this_page = 'news';
  echo $side;
?>

<div id="content">
<div id="ad"><iframe src="/htm/ad_blank/" width="320" height="50" frameborder="0" scrolling="no"></iframe></div>

<table id="cel"></table>

</div>
<div id="ad_right"></div>
<script>
  var csrf = '<?=Model_Csrf::setcsrf()?>';
</script>
<script src="/assets/js/basic.js?ver=96"></script>
<script src="/assets/js/news.js?ver=96"></script>
<script>
  $(function(){ ga('send', 'pageview'); });
</script>
</body>
</html>