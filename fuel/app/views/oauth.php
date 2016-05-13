<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8" />
    <title>ログイン完了</title>
    <link rel="shortcut icon" href="/assets/img/icon/quiz_generator.png" />
    <meta name="robots" content="noindex">
    <script src="/third/jquery-2.1.1.min.js"></script>
    <script src="/third/jquery.cookie.js"></script>
    <script>var ua = '<?=Config::get("my.ua")?>';</script>
    <script src="/assets/js/analytics.js?ver=70"></script>
    <link rel="stylesheet" type="text/css" href="/assets/css/basic.css?ver=70" />
    <link rel="stylesheet" href="/assets/css/pc.css?ver=70" media="only screen and (min-width : 711px)">
    <link rel="stylesheet" href="/assets/css/sp.css?ver=70" media="only screen and (max-width : 710px)">
    <meta name="viewport" content="width=device-width, user-scalable=no" >
  </head>
<body>
<table cellspacing="0" boroder="0" id="header">
  <td class="edge"><img src="/assets/img/icon/menu.png" alt="menu" class="icon" id="menu"></td>
  <td id="center"><h1 class="font_8 unread">ログイン完了</h1></td>
  <td class="edge">
    <img src="/assets/img/icon/upload_0.png" alt="generate" class="icon" id="generate">
    <img src="/assets/img/icon/success.png" alt="success" class="icon" id="success" style="display:none;">
    <img src="/assets/img/icon/cross_big.png" alt="success" class="icon" id="delete" style="display:none;">
  </td>
</table>
<?php
  $side = View::forge('side');
  $side->this_page = 'myprofile';
  echo $side;
?>

<div id="content">
<div id="ad"></div>
&nbsp;
</div>
<div id="ad_right"></div>

<script>
var u_id = '<?=$u_id?>';

var follow = '<?=$follow?>';
var myname = '<?=$myname?>';
var myphoto = '<?=$myphoto?>';
var point = '<?=$point?>';
var ua_u_id = '<?=$u_id?>';
var answer_by_u = '<?=$js_answer_by_u?>';
var answer = '<?=$js_answer?>';
var offline_q = '<?=$js_offline_q?>';
var introduce = '<?=$introduce?>';
  
if(follow){
  localStorage.follow = follow;
}
if(myname){
  localStorage.myname = myname;
}
if(myphoto){
  localStorage.myphoto = myphoto;
}
if(point){
  localStorage.point = point;
}
if(ua_u_id){
  localStorage.ua_u_id = ua_u_id;
}
if(answer_by_u){
  localStorage.answer_by_u = answer_by_u;
}
if(answer){
  localStorage.answer = answer;
}
if(offline_q){
  localStorage.offline_q = offline_q;
}
if(introduce){
  localStorage.introduce = introduce;
}

location.href = '/myprofile/ ';

</script>
<script src="/assets/js/basic.js?ver=70"></script>
<script>
  $(function(){ ga('send', 'pageview'); });
</script>
</body>
</html>

