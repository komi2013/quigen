<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8" />
    <title>make word quiz</title>
    <link rel="shortcut icon" href="/assets/img/icon/quiz_generator.png" />
    <meta name="robots" content="noindex">
    <script src="/third/jquery-2.1.1.min.js"></script>
    <script src="/third/jquery.cookie.js"></script>
    <script>var ua = '<?=Config::get("my.ua")?>';</script>
    <script src="/assets/js/analytics.js<?=Config::get("my.cache_v")?>"></script>
    <link rel="stylesheet" type="text/css" href="/assets/css/basic.css<?=Config::get("my.cache_v")?>" />
    <link rel="stylesheet" href="/assets/css/pc.css<?=Config::get("my.cache_v")?>" media="only screen and (min-width : 711px)">
    <link rel="stylesheet" href="/assets/css/sp.css<?=Config::get("my.cache_v")?>" media="only screen and (max-width : 710px)">
    <meta name="viewport" content="width=device-width, user-scalable=no" >
  </head>
<body>

<?php
  $side = View::forge('side');
  $side->this_page = 'gene4word';
  echo $side;
?>
<div id="content">
<table>
<tr><td><input type="text" placeholder="Q." maxlength="20" class="txt_99" id="q_0"></td><td><input type="text" placeholder="A." maxlength="200" class="txt_99" id="a_0"></td></tr>
<tr><td><input type="text" placeholder="Q." maxlength="20" class="txt_99" id="q_1"></td><td><input type="text" placeholder="A." maxlength="200" class="txt_99" id="a_1"></td></tr>
<tr><td><input type="text" placeholder="Q." maxlength="20" class="txt_99" id="q_2"></td><td><input type="text" placeholder="A." maxlength="200" class="txt_99" id="a_2"></td></tr>
<tr><td><input type="text" placeholder="Q." maxlength="20" class="txt_99" id="q_3"></td><td><input type="text" placeholder="A." maxlength="200" class="txt_99" id="a_3"></td></tr>
</table>
<div style="width:98%;text-align:right;">
  <img src="/assets/img/icon/upload_0.png" alt="generate" class="icon" id="generate">
  <img src="/assets/img/icon/success.png" alt="success" class="icon" id="success" style="display:none;">  
</div>

<table>
  <tr>
  <td class="another_page"> <a href="/generate/?q_type=textbox">
    <img src="/assets/img/icon/textbox.png" class="icon">
  </a> </td>
  <td class="another_page"> <a href="/generate/">
    <img src="/assets/img/icon/choice.png" class="icon">
  </a> </td>
  <td class="this_page"> <a href="/gene4word/">
    <img src="/assets/img/icon/multiple.png" class="icon">
  </a> </td>
  </tr>
</table>
<table>
  <tr><td>#<input type="text" placeholder="category" maxlength="12" class="txt_84" id="tag_0"></td></tr>
</table>
<div style="display:none;">
<input type="text" placeholder="add tag.." maxlength="12" class="tag_in" id="tag_1">
<input type="text" placeholder="add tag.." maxlength="12" class="tag_in" id="tag_2">
</div>
<div id="ad"><iframe src="/htm/ad_blank/" width="320" height="50" frameborder="0" scrolling="no"></iframe></div>
</div>
<div id="ad_right"></div>
<script>
  var u_id = '<?=$u_id?>';
  var csrf = '<?=Model_Csrf::setcsrf()?>';
</script>
<script src="/assets/js/check_news.js<?=Config::get("my.cache_v")?>"></script>
<script src="/assets/js/basic.js<?=Config::get("my.cache_v")?>"></script>
<script src="/assets/js/generate_4word.js<?=Config::get("my.cache_v")?>"></script>
<script>
  $(function(){ ga('send', 'pageview'); });
</script>
</body>
</html>

