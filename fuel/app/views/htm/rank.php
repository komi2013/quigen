<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8" />
    <title>ランク</title>
    <link rel="shortcut icon" href="/assets/img/icon/quiz_generator.png">
    <meta name="robots" content="noindex">
    <script src="/third/jquery-2.1.1.min.js"></script>
    <script src="/third/jquery.cookie.js"></script>
    <script>var ua = '<?=Config::get("my.ua")?>';</script>
    <script src="/assets/js/analytics.js?ver=42"></script>
    <link rel="stylesheet" type="text/css" href="/assets/css/basic.css?ver=42" />
    <link rel="stylesheet" href="/assets/css/pc.css?ver=42" media="only screen and (min-width : 711px)">
    <link rel="stylesheet" href="/assets/css/sp.css?ver=42" media="only screen and (max-width : 710px)">
    <meta name="viewport" content="width=device-width, user-scalable=no" >
  </head>
<body>
<table cellspacing="0" boroder="0" id="header">
  <td class="edge"><img src="/assets/img/icon/menu.png" alt="menu" class="icon" id="menu"></td>
  <td id="center"><h1 class="unread font_8">ランク</h1></td>
  <td class="edge"><img src="/assets/img/icon/magnifier.png" alt="search" class="icon" id="search"></td>
</table>
<?php
  $side = View::forge('side');
  $side->this_page = 'rank';
  echo $side;
?>

<div id="content">
<table>
  <tr><td style="text-align: center;">
    <select class="txt_84" id="tag_name">
      <option value="#中学歴史">#中学歴史</option>
      <option value="#センター日本史">#センター日本史</option>
      <option value="#センター世界史">#センター世界史</option>
      <option value="#センター生物">#センター生物</option>
      <option value="#センター化学">#センター化学</option>
      <option value="#センター英語初級">#センター英語初級</option>
      <option value="#センター英語中級">#センター英語中級</option>
      <option value="#センター英語上級">#センター英語上級</option>
      <option value="#大学受験英熟語">#大学受験英熟語</option>
      <option value="#休憩">#休憩</option>
    </select>
  </td></tr>
</table>
<table id="cel"></table>
<?= View::forge('htm/ad_load') ?>
</div>
<?= View::forge('htm/ad_load_right') ?>

<script src="/assets/js/basic.js?ver=42"></script>
<script src="/assets/js/check_news.js?ver=42"></script>
<script src="/assets/js/rank.js?ver=42"></script>
</body>
</html>