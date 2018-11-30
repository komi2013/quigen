<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8" />
    <title>make quiz</title>
    <meta name="description" content="you can make unofficial quiz, if you share, your friend can answer your quiz">
    <link rel="shortcut icon" href="/assets/img/icon/quiz_generator.png" />
    <link rel="canonical" href="<?='http://'.Config::get("my.domain").'/generate/'?>" />
    <script src="/third/jquery-2.1.1.min.js"></script>
    <script src="/third/jquery.cookie.js"></script>
    <script>var ua = '<?=Config::get("my.ua")?>';</script>
    <script src="/assets/js/analytics.js?ver=97"></script>
    <link rel="stylesheet" type="text/css" href="/assets/css/basic.css?ver=97" />
    <link rel="stylesheet" href="/assets/css/pc.css?ver=97" media="only screen and (min-width : 711px)">
    <link rel="stylesheet" href="/assets/css/sp.css?ver=97" media="only screen and (max-width : 710px)">
    <meta name="viewport" content="width=device-width, user-scalable=no" >
  </head>
<body>
<script src="/third/img-touch-canvas_1.js?ver=97"></script>
<?php
  $side = View::forge('side');
  $side->this_page = 'generate';
  echo $side;
?>
<div id="content">

<table style="text-align:center;">
<tr><td><textarea placeholder="Q." maxlength="2000" class="txt_long" id="q_txt"></textarea></td></tr>
</table>
<?php if(isset($_GET['q_type']) AND $_GET['q_type'] == 'textbox'){ ?>
<table id="from_text" style="text-align:center;">
<tr><td><input type="text" placeholder="answer" maxlength="1000" class="txt_99" id="textbox"></td></tr>
</table>
<?php } else { ?>
<table id="from_text" style="text-align:center;">
<tr><td><input type="text" placeholder="O" maxlength="1000" class="txt_99" id="choice_0"></td></tr>
<tr><td><input type="text" placeholder="X" maxlength="1000" class="txt_99" id="choice_1"></td></tr>
<tr><td><input type="text" placeholder="X" maxlength="1000" class="txt_99" id="choice_2"></td></tr>
<tr><td><input type="text" placeholder="X" maxlength="1000" class="txt_99" id="choice_3"></td></tr>
</table>
<?php } ?>
<div style="width:98%;text-align:right;">
  <img src="/assets/img/icon/upload_0.png" alt="generate" class="icon" id="generate">
  <img src="/assets/img/icon/success.png" alt="success" class="icon" id="success" style="display:none;">  
</div>
<table><tr><td class="td_99_c">option</td></tr></table>
<?php if(isset($_GET['q_type']) AND $_GET['q_type'] == 'textbox'){ ?>
<table><tr><td class="td_99_c"><a href="/generate/">multiple choice</a></td></tr></table>
<?php } else {?>
<table><tr><td class="td_99_c"><a href="/generate/?q_type=textbox">single textbox</a></td></tr></table>
<?php } ?>
<table>
  <tr><td class="tag">#<input type="text" placeholder="add tag.." maxlength="12" class="txt_84" id="tag_0"></td></tr>
</table>
<div style="display:none;">
<input type="text" placeholder="add tag.." maxlength="12" class="tag_in" id="tag_1">
<input type="text" placeholder="add tag.." maxlength="12" class="tag_in" id="tag_2">
</div>    

<table>
  <tr><td class="td_99"><input type="text" placeholder="reference:" maxlength="1000" class="txt_99" id="reference"></td></tr>
</table>

<table cellspacing="0">
  <tr>
  <td id="rotate" style="width:50px;"><img src="/assets/img/icon/rotate.png" class="icon" alt="rotate"></td>
  <td id="minus" class="sp_disp_none" style="width:50px;"><img src="/assets/img/icon/minus.png" class="icon" alt="minus"></td>
  <td class="sp_disp_none" style="width:50px;">
    <select name='scale' style="font-size:20px;">
        <option>1</option>
        <option>5</option>
        <option>10</option>
        <option>20</option>
        <option>40</option>
    </select>
  </td>
  <td id="plus" class="sp_disp_none" style="width:50px;"><img src="/assets/img/icon/plus.png" class="icon" alt="plus"></td>
  </tr>
</table>

<div id="canvas_div_img" style="text-align:center;">
<input type="file" id="imageLoader" name="imageLoader">
<canvas id="mycanvas" height="300" width="300"></canvas>
</div>

<div id="ad"><iframe src="/htm/ad_blank/" width="320" height="50" frameborder="0" scrolling="no"></iframe></div>
</div>

<div id="ad_right"></div>

<script>
var u_id = '<?=$u_id?>';
var csrf = '<?=Model_Csrf::setcsrf()?>';
var q_type = '<?=isset($_GET['q_type']) ? $_GET['q_type'] : ''?>';
</script>
<script src="/assets/js/check_news.js?ver=97"></script>
<script src="/assets/js/basic.js?ver=97"></script>
<script src="/assets/js/generate.js?ver=97"></script>
<script>
  $(function(){ ga('send', 'pageview'); });
</script>
</body>
</html>

