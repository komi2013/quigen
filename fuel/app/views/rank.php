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
    <script src="/assets/js/analytics.js?ver=73"></script>
    <link rel="stylesheet" type="text/css" href="/assets/css/basic.css?ver=73" />
    <link rel="stylesheet" href="/assets/css/pc.css?ver=73" media="only screen and (min-width : 711px)">
    <link rel="stylesheet" href="/assets/css/sp.css?ver=73" media="only screen and (max-width : 710px)">
    <meta name="viewport" content="width=device-width, user-scalable=no" >
  </head>
<body>
<table cellspacing="0" boroder="0" id="header">
  <td class="edge"><img src="/assets/img/icon/menu.png" alt="menu" class="icon" id="menu"></td>
  <td id="center"><h1 class="unread font_8">ランク</h1></td>
  <td class="edge"></td>
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
      <?php foreach($tag_rank as $d){ ?>
        <option value="#<?=$d['tag']?>">#<?=$d['tag']?></option>
      <?php } ?>
    </select>
  </td></tr>
</table>
<table id="cel"></table>
<div id="ad"></div>
</div>
<div id="ad_right"></div>

<script src="/assets/js/basic.js?ver=73"></script>
<script src="/assets/js/check_news.js?ver=73"></script>
<script src="/assets/js/rank.js?ver=73"></script>
<script>
  $(function(){ ga('send', 'pageview'); });
</script>
</body>
</html>