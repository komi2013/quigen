<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8" />
    <title>quest</title>
    <link rel="shortcut icon" href="/assets/img/icon/quiz_generator.png" />
    <meta name="robots" content="noindex">
    <script src="/third/jquery-2.1.1.min.js"></script>
    <script src="/third/jquery.cookie.js"></script>
    <script>var ua = '<?=Config::get("my.ua")?>';</script>
    <script src="/assets/js/analytics.js?ver=94"></script>
    <link rel="stylesheet" type="text/css" href="/assets/css/basic.css?ver=94" />
    <link rel="stylesheet" href="/assets/css/pc.css?ver=94" media="only screen and (min-width : 711px)">
    <link rel="stylesheet" href="/assets/css/sp.css?ver=94" media="only screen and (max-width : 710px)">
    <meta name="viewport" content="width=device-width, user-scalable=no" >
  </head>
<body>
<style>
.quest_do{
  background-color: #CBFFD3;
}
</style>

<?php
  $side = View::forge('side');
  $side->this_page = '';
  echo $side;
?>

<div id="content">
<div id="ad"><iframe src="/htm/ad_blank/" width="320" height="50" frameborder="0" scrolling="no"></iframe></div>
<table>
  <tr>
    <td class="td_68"><a id="pre_quiz" href="/">back to quiz</a></td>
    <td class="td_15"><img src="/assets/img/icon/ticket.png" alt="ticket"></td>
    <td class="td_15" id="ticket" style="color:red;">0</td>
  </tr>
</table>

<table>
  <tr><td class="td_99 quest_do" id="light_2">you can get ticket after this time</td></tr>  
</table>

<table>
  <tr></tr>
</table>

<table>
  <tr>
    <td class="td_15" rowspan="2"><img src="/assets/img/icon/hourglass.png" alt="wait"></td>
    <td class="td_84" id="open_time" style="text-align:center;"></td>
  </tr>
  <tr><td class="td_84" id="left_time" style="text-align:center;">0</td></tr>
</table>
<br>
<table>
  <tr><td class="td_99 quest_do" id="light_1">or you go to those pages to get ticket</td></tr>
</table>

<table>
  <tr><td class="quest_1 td_99_c">answer quiz</td>                                   <td class="td_15_c"><img src="/assets/img/icon/star_1.png"></td></tr>
  <tr><td class="quest_1 td_99_c"><a href="/">go other quiz</a></td>             <td class="td_15_c" id="img_quest_0"><img src="/assets/img/icon/star_0.png"></td></tr>
  <tr><td class="quest_1 td_99_c"><a href="/htm/myanswer_offline/">go offline</a></td> <td class="td_15_c" id="img_quest_1"><img src="/assets/img/icon/star_0.png"></td></tr>
  <tr><td class="quest_1 td_99_c"><a href="/myprofile/">go mypage</a></td> <td class="td_15_c" id="img_quest_2"><img src="/assets/img/icon/star_0.png"></td></tr>

  <tr><td class="quest_2 td_99_c"><a href="/forumlist/">go chat</a></td>         <td class="quest_2 td_15_c" id="img_quest_3"><img src="/assets/img/icon/star_0.png"></td></tr>
  <tr><td class="quest_2 td_99_c"><a href="/htm/rule/">go rule</a></td>    <td class="quest_2 td_15_c" id="img_quest_4"><img src="/assets/img/icon/star_0.png"></td></tr>
  <tr><td class="quest_2 td_99_c">share quiz</td>                                   <td class="quest_2 td_15_c" id="img_quest_5"><img src="/assets/img/icon/star_0.png"></td></tr>
  <tr><td class="quest_2 td_99_c">comment on quiz</td>                                 <td class="quest_2 td_15_c" id="img_quest_6"><img src="/assets/img/icon/star_0.png"></td></tr>
  <tr><td class="quest_2 td_99_c">make quiz</td>                                     <td class="quest_2 td_15_c" id="img_quest_7"><img src="/assets/img/icon/star_0.png"></td></tr>
</table>
<br>
<table>
  <tr>
    <td class="td_84 quest_do" id="light_3">or get ticket with point</td>
    <td class="td_15 quest_do">
      <img src="/assets/img/icon/upload_0.png" alt="generate" class="icon" id="generate">
      <img src="/assets/img/icon/success.png" alt="success" class="icon" id="success" style="display:none;">
    </td>
  </tr>  
</table>

<table>
<tr><td class="td_49">my point</td><td class="td_49" id="point">0 pt</td></tr>
</table>

<table>
  <tr>
    <td class="td_15"><input type="radio" name="pay_point" value="100"></td>
    <td class="td_42">100 point</td>
    <td class="td_42">20 ticket</td>
  </tr>
  <tr>
    <td class="td_15"><input type="radio" name="pay_point" value="800"></td>
    <td class="td_42">800 point</td>
    <td class="td_42">170 ticket</td>
  </tr>
  <tr>
    <td class="td_15"><input type="radio" name="pay_point" value="1400"></td>
    <td class="td_42">1400 point</td>
    <td class="td_42">300 ticket</td>
  </tr>
</table>

<table>
  <tr>
  <td class="td_99_c"><a href="/htm/exchange_point/?send=1">buy point</a></td>
  </tr>
</table>

<div id="ad"><iframe src="/htm/ad_blank/" width="320" height="50" frameborder="0" scrolling="no"></iframe></div>
</div>
<div id="ad_right"></div>

<script>
  var u_id = '<?=@$u_id?>';
  var csrf = '<?=Model_Csrf::setcsrf()?>';
</script>
<script src="/assets/js/basic.js?ver=94"></script>
<script src="/assets/js/check_news.js?ver=94"></script>
<script src="/assets/js/quest.js?ver=94"></script>
<script>
  $(function(){ ga('send', 'pageview'); });
</script>
</body>
</html>