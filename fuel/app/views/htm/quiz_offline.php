<!DOCTYPE html>
<html manifest="/mf.manifest">
  <head>
    <meta charset="UTF-8" />
    <title>オフラインクイズ</title>
    <meta name="robots" content="noindex">
    <link rel="shortcut icon" href="/assets/img/icon/quiz_generator.png">
    <script src="/third/jquery-2.1.1.min.js"></script>
    <script src="/third/jquery.cookie.js"></script>
    <link rel="stylesheet" type="text/css" href="/assets/css/quiz.css" />
    <script>var ua = '<?=Config::get("my.ua")?>';</script>
    <script src="/assets/js/analytics_offline.js"></script>
    <meta property="og:image" content="http://<?=Config::get('my.domain').'/assets/img/icon/qg_big.png'?>" />
    <link rel="stylesheet" type="text/css" href="/assets/css/basic.css" />
    <link rel="stylesheet" href="/assets/css/pc.css" media="only screen and (min-width : 711px)">
    <link rel="stylesheet" href="/assets/css/sp.css" media="only screen and (max-width : 710px)">
    <meta name="viewport" content="width=device-width, user-scalable=no" >
  </head>
<body>

<table cellspacing="0" boroder="0" id="header">
  <td class="edge"><img src="/assets/img/icon/menu.png" alt="menu" class="icon" id="menu"></td>
  <td id="center"><h1 class="unread font_8"></h1></td>
  <td class="edge" id="right"><img src="/assets/img/icon/no_internet.png" alt="menu" class="icon" id="menu"></td>
</table>
<?php
  $side = View::forge('side');
  $side->this_page = '';
  echo $side;
?>

<div id="content">
<br> <div id="ad"><iframe src="/htm/ad_blank/" width="320" height="50" frameborder="0" scrolling="no"></iframe></div>

<div id="div_photo">
<img src="/assets/img/icon/no_img.png" alt="quiz photo" id="photo">
</div>

<table><tr>
  <td id="question" class="td_99_box"></td>
</tr></table>
<div id="big_result">
<img src="/assets/img/icon/circle_big.png" alt="correct" class="big_icon" id="big_correct" style="display:none;">
<img src="/assets/img/icon/cross_big.png" alt="incorrect" class="big_icon" id="big_incorrect" style="display:none;">
<table>
  <tr><td class="choice" id="choice_0"></td></tr>
  <tr><td class="choice" id="choice_1"></td></tr>
  <tr><td class="choice" id="choice_2"></td></tr>
  <tr><td class="choice" id="choice_3"></td></tr>
</table>
</div>

<table id="sns">
<tr>
<td style="width:70px;">
  <a href="" target="_blank" id="href_fb">
    <img src="/assets/img/icon/fb.jpg" alt="facebook" class="icon">
  </a>
</td>
<td style="width:70px;">
  <a href="" target="_blank" id="href_tw">
  <img src="/assets/img/icon/tw.jpg" alt="twitter" class="icon">
  </a>
</td>
<td style="width:70px;">
  <a href="" target="_blank" id="href_ln">
  <img src="/assets/img/icon/ln.jpg" alt="line" class="icon">
  </a>
</td>
<td style="width:70px;">
  <a href="" target="_blank" id="href_clip">
  <img src="/assets/img/icon/clip.png" alt="line" class="icon">
  </a>
</td>
</tr>
<tr>
  <td colspan="4" style="text-align:center;">
<textarea style="width:90%;" id="whole_url"></textarea>
  </td>
</tr>
</table>
<div id="comment" style="word-wrap:break-word;"></div>
<table id="next_prev"></table>

</div>

<div id="ad_right"></div>
<script>
var domain = '<?=Config::get('my.domain')?>';
</script>
<script src="/assets/js/basic_offline.js"></script>
<script src="/assets/js/check_news.js"></script>
<script src="/assets/js/quiz_offline.js"></script>
<script>  
if(navigator.onLine){
  $(function(){ ga('send', 'pageview'); });
}
</script>
</body>
</html>

