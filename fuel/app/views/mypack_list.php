<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8" />
    <title>マイパックリスト</title>
    <link rel="shortcut icon" href="/assets/img/icon/quiz_generator.png" />
    <meta name="robots" content="noindex">
    <script src="/third/jquery-2.1.1.min.js"></script>
    <script src="/third/jquery.cookie.js"></script>
    <script>var ua = '<?=Config::get("my.ua")?>';</script>
    <script src="/assets/js/analytics.js?ver=59"></script>
    <link rel="stylesheet" type="text/css" href="/assets/css/basic.css?ver=59" />
    <link rel="stylesheet" href="/assets/css/pc.css?ver=59" media="only screen and (min-width : 711px)">
    <link rel="stylesheet" href="/assets/css/sp.css?ver=59" media="only screen and (max-width : 710px)">
    <meta name="viewport" content="width=device-width, user-scalable=no" >
  </head>
<body>

<table cellspacing="0" boroder="0" id="header">
  <td class="edge"><img src="/assets/img/icon/menu.png" alt="menu" class="icon" id="menu"></td>
  <td id="center"><h1 class="font_8 unread">マイパックリスト</h1></td>
  <td class="edge">
    <img src="/assets/img/icon/upload_0.png" alt="generate" class="icon" id="generate">
    <img src="/assets/img/icon/success.png" alt="success" class="icon" id="success" style="display:none;">
    <img src="/assets/img/icon/cross_big.png" alt="delete" class="icon" id="delete" style="display:none;">
  </td>
</table>
<?php
  $side = View::forge('side');
  $side->this_page = 'mypacklist';
  echo $side;
?>

<div id="content">
<table>
<tr><td class="td_49">所持ポイント</td><td class="td_49" id="point"></td></tr>
</table>

<table id="pack_input">
  <tr>
  <td style="text-align:center;"><input type="text" placeholder="クイズパックのタイトル" maxlength="12" id="pack_txt"></td>
  </tr>
</table>
<table>
  <tr>
  <td class="td_98_c"><a href="/htm/exchange_point/">ポイント交換する</a></td>
  </tr>
</table>

<?= View::forge('htm/ad_load') ?>
<table id="cel"></table>
</div>
<script>
  var u_id = '<?=$u_id?>';
  var csrf = '<?=Model_Csrf::setcsrf()?>';
</script>
<script src="/assets/js/basic.js?ver=59"></script>
<script src="/assets/js/check_news.js?ver=59"></script>
<script src="/assets/js/mypack_list.js?ver=59"></script>
<script>
  ga('send', 'pageview');
</script>
</body>
</html>

