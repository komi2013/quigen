<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8" />
    <title>お知らせ</title>
    <link rel="shortcut icon" href="/assets/img/icon/quiz_generator.png" />
    <meta name="robots" content="noindex">
    <script src="/third/jquery-2.1.1.min.js"></script>
    <script src="/third/jquery.cookie.js"></script>
    <script>var ua = '<?=Config::get("my.ua")?>';</script>
    <script src="/assets/js/analytics.js?ver=49"></script>
    <link rel="stylesheet" type="text/css" href="/assets/css/basic.css?ver=49" />
    <link rel="stylesheet" href="/assets/css/pc.css?ver=49" media="only screen and (min-width : 711px)">
    <link rel="stylesheet" href="/assets/css/sp.css?ver=49" media="only screen and (max-width : 710px)">
    <meta name="viewport" content="width=device-width, user-scalable=no" >
  </head>
<body>
<table cellspacing="0" boroder="0" id="header">
  <td class="edge"><img src="/assets/img/icon/menu.png" alt="menu" class="icon" id="menu"></td>
  <td id="center"><h1 class="font_8 unread">お知らせ</h1></td>
  <td class="edge"></td>
</table>
<?php
  $side = View::forge('side');
  $side->this_page = 'news';
  echo $side;
?>

<div id="content">
<?= View::forge('htm/ad_load') ?>

<table id="cel"></table>
<div><a href="http://quizgenerator-help.hatenadiary.jp/entry/2015/07/09/192249">1問20円でクイズの作成にご協力ください</a></div>
</div>
<?= View::forge('htm/ad_load_right') ?>
<script>
  var csrf = '<?=Model_Csrf::setcsrf()?>';
</script>
<script src="/assets/js/basic.js?ver=49"></script>
<script src="/assets/js/news.js?ver=49"></script>
<script>
  ga('send', 'pageview');
</script>
</body>
</html>