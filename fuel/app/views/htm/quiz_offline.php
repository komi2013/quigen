<!DOCTYPE html>
<html manifest="/mf.manifest">
  <head>
    <meta charset="UTF-8" />
    <title>offline quiz</title>
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

<table class="textbox"><tr><td class="txt_99" id="txt_answer" contenteditable='true'></td></tr></table>

<div class="textbox" style="width:98%;text-align:right;">
  <img src="/assets/img/icon/upload_0.png" alt="generate" class="icon" id="descriptive">
</div>

<table class="choice_q" >
  <tr><td class="choice" id="choice_0"></td></tr>
  <tr><td class="choice" id="choice_1"></td></tr>
  <tr><td class="choice" id="choice_2"></td></tr>
  <tr><td class="choice" id="choice_3"></td></tr>
</table>

</div>

<table class="alter_an">
  <tr>
  <td id="textbox" class="chg_an_type" an_type="textbox"> <img src="/assets/img/icon/textbox.png" class="icon"></td>
  <td id="choice_q" class="chg_an_type" an_type="choice_an"> <img src="/assets/img/icon/choice.png" class="icon"> </td>
  </tr>
</table>

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
  <a href="" target="_blank" id="href_ln" class="pc_disp_none">
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
var no_ = '<?=Config::get("lang.no_")?>';
var mon = '<?=Config::get("lang.mon")?>';
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

