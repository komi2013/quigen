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
    <script src="/assets/js/analytics.js"></script>
    <meta property="og:image" content="http://<?=Config::get('my.domain').'/assets/img/icon/qg_big.png'?>" />
    <link rel="stylesheet" type="text/css" href="/assets/css/basic.css" />
    <link rel="stylesheet" href="/assets/css/pc.css" media="only screen and (min-width : 711px)">
    <link rel="stylesheet" href="/assets/css/sp.css" media="only screen and (max-width : 710px)">
    <meta name="viewport" content="width=device-width, user-scalable=no" >
  </head>
<body>

<table cellspacing="0" boroder="0" id="header">
  <td class="edge"><img src="/assets/img/icon/menu.png" alt="menu" class="icon" id="menu"></td>
  <td id="center"><h1 class="unread font_8">オフライン</h1></td>
  <td class="edge" id="right"></td>
</table>
<?php
  $side = View::forge('side');
  $side->this_page = '';
  echo $side;
?>

<div id="content">
<br> <?= View::forge('htm/ad_load') ?>

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
<table cellspacing="1" boroder="0">
<tr>
  <td class="td_15"><img src="/assets/img/icon/circle_big.png" alt="correct ratio" class="icon"></td>
  <td class="td_15" id="num_ratio">0 % </td>
  <td class="td_15"><img src="/assets/img/icon/answer.png" alt="amount of answer" class="icon"></td>
  <td class="td_15" id="num_answer">0</td>
  <td class="td_15"><img src="/assets/img/icon/ticket.png" alt="ticket"></td>
  <td class="td_15" id="ticket" style="color:red;">0</td>
</tr>
</table>
<table cellspacing="0" boroder="0">
<tr>

<?php $i=0; while($i<16){ ?>
  <?php if($i == 8){ ?>
    </tr><tr>
  <?php } ?>
  <td id="co_<?=$i?>" class="ans_u_correct"></td>

<?php ++$i;} ?>
</tr>

</table>

<table cellspacing="0" boroder="0">
<tr>
<?php $i=0; while($i<16){ ?>
  <?php if($i == 8){ ?>
    </tr><tr>
  <?php } ?>
  <td id="inco_<?=$i?>" class="ans_u_incorrect"></td>

<?php ++$i;} ?>
</tr>
</table>

<table id="comment"></table>
<table id="comment_in"></table>
<br>
<table cellspacing="0" cellspacing="1" boroder="0">
  <tr><td id="tag"></td></tr>
</table>
<br>
<table>
  <tr> <td class="td_33" id="prev"></td> <td class="td_33">||</td> <td class="td_33" id="next"></td> </tr>
</table>
<br>
<table cellspacing="1" boroder="0" id="sns">
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
<br>

<table>
<tr>
<td style="width:98%;text-align:right;">
  <img src="/assets/img/icon/exclamation.png" alt="report" id="report" class="icon">
</td>
</tr>
</table>

<table style="display: none;">
<tr><td colspan="2" class="td_98">このクイズを購入</td></tr>
<tr>
<td class="td_32">
  <a href="#" id="20pt">20 pt</a>
</td>
<td class="td_32">
  <a href="#" id="0pt">0 pt</a>
</td>
</tr>
</table>
</div>

<?= View::forge('htm/ad_load_right') ?>
<script>
var domain = '<?=Config::get('my.domain')?>';
</script>
<script src="/assets/js/basic.js"></script>
<script src="/assets/js/check_news.js"></script>
<script src="/assets/js/offline_quiz.js"></script>
<script>
  ga('send', 'pageview');
</script>

</body>
</html>

