<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8" />
    <title>単語クイズ作成</title>
    <link rel="shortcut icon" href="/assets/img/icon/quiz_generator.png" />
    <meta name="robots" content="noindex">
    <script src="/third/jquery-2.1.1.min.js"></script>
    <script src="/third/jquery.cookie.js"></script>
    <script>var ua = '<?=Config::get("my.ua")?>';</script>
    <script src="/assets/js/analytics.js?ver=64"></script>
    <link rel="stylesheet" type="text/css" href="/assets/css/basic.css?ver=64" />
    <link rel="stylesheet" href="/assets/css/pc.css?ver=64" media="only screen and (min-width : 711px)">
    <link rel="stylesheet" href="/assets/css/sp.css?ver=64" media="only screen and (max-width : 710px)">
    <meta name="viewport" content="width=device-width, user-scalable=no" >
  </head>
<body>

<table cellspacing="0" boroder="0" id="header">
  <td class="edge"><img src="/assets/img/icon/menu.png" alt="menu" class="icon" id="menu"></td>
  <td id="center"><h1 class="font_8 unread">単語クイズ作成</h1></td>
  <td class="edge">
    <img src="/assets/img/icon/upload_0.png" alt="generate" class="icon" id="generate">
    <img src="/assets/img/icon/success.png" alt="success" class="icon" id="success" style="display:none;">
  </td>
</table>
<?php
  $side = View::forge('side');
  $side->this_page = 'gene4word';
  echo $side;
?>
<div id="content">
<table>
<tr><td><input type="text" placeholder="質問" maxlength="20" class="txt_99" id="q_0"></td><td><input type="text" placeholder="答え" maxlength="20" class="txt_99" id="a_0"></td></tr>
<tr><td><input type="text" placeholder="質問" maxlength="20" class="txt_99" id="q_1"></td><td><input type="text" placeholder="答え" maxlength="20" class="txt_99" id="a_1"></td></tr>
<tr><td><input type="text" placeholder="質問" maxlength="20" class="txt_99" id="q_2"></td><td><input type="text" placeholder="答え" maxlength="20" class="txt_99" id="a_2"></td></tr>
<tr><td><input type="text" placeholder="質問" maxlength="20" class="txt_99" id="q_3"></td><td><input type="text" placeholder="答え" maxlength="20" class="txt_99" id="a_3"></td></tr>
</table>
<table>
  <tr><td class="td_99_c">オプション</td></tr>  
</table>

<table>
  <tr><td>#<input type="text" placeholder="タグを追加.." maxlength="12" class="txt_84" id="tag_0"></td></tr>
</table>
<div style="display:none;">
<input type="text" placeholder="タグを追加.." maxlength="12" class="tag_in" id="tag_1">
<input type="text" placeholder="タグを追加.." maxlength="12" class="tag_in" id="tag_2">
</div>
<?= View::forge('htm/ad_load') ?>
</div>
<script>
  var u_id = '<?=$u_id?>';
  var csrf = '<?=Model_Csrf::setcsrf()?>';
</script>
<script src="/assets/js/check_news.js?ver=64"></script>
<script src="/assets/js/basic.js?ver=64"></script>
<script src="/assets/js/generate_4word.js?ver=64"></script>
<script>
  ga('send', 'pageview');
</script>
</body>
</html>

