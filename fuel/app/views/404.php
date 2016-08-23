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
    <script src="/assets/js/analytics.js?ver=91"></script>
    <link rel="stylesheet" type="text/css" href="/assets/css/basic.css?ver=91" />
    <link rel="stylesheet" href="/assets/css/pc.css?ver=91" media="only screen and (min-width : 711px)">
    <link rel="stylesheet" href="/assets/css/sp.css?ver=91" media="only screen and (max-width : 710px)">
    <meta name="viewport" content="width=device-width, user-scalable=no" >
  </head>
<body>

<?php
  $side = View::forge('side');
  $side->this_page = '';
  echo $side;
?>
<div id="content">

<h1>Not Found</h1>
<div id="ad"><iframe src="/htm/ad_blank/" width="320" height="50" frameborder="0" scrolling="no"></iframe></div>
</div>

<div id="ad_right"></div>

<script src="/assets/js/check_news.js?ver=91"></script>
<script src="/assets/js/basic.js?ver=91"></script>
<?php Model_Log::notice('Not Found');?>
<script>
  $(function(){ ga('send', 'pageview', location.pathname + location.search + location.hash +':404'); });
</script>
</body>
</html>
