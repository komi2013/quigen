<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8" />
    <title>mypage</title>
    <link rel="shortcut icon" href="/assets/img/icon/quiz_generator.png" />
    <meta name="robots" content="noindex">
    <script src="/third/jquery-2.1.1.min.js"></script>
    <script src="/third/jquery.cookie.js"></script>
    <script src="/third/vue.min.js"></script>
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
  $side->this_page = 'myprofile';
  echo $side;
?>

<div id="content">
<div class="img_input">
  <span id="photo_res"><img src="/assets/img/icon/camera.png" id="photo" class="icon"></span>
  <input type="text" placeholder="name" maxlength="12" id="myname" class="input_with" v-model="myname">
</div>

<div style="text-align:center;width:100%;">
  <textarea placeholder="introduce.." maxlength="120" id="introduce" class="txt_long">{{introduce}}</textarea>
</div>

<table>
  <tr>
    <td style="width:20%;">
      <img src="/assets/img/icon/fb.jpg" alt="facebook" class="icon auth"
data-url="https://www.facebook.com/dialog/oauth?client_id=<?=Config::get('my.fb_id')?>&redirect_uri=https://<?=$_SERVER['HTTP_HOST']?>/fboauth/">
    </td>
    <td style="width:20%">
      <img src="/assets/img/icon/tw.jpg" alt="twitter" class="icon auth" data-url="/twoauth/">
    </td>
    <td style="width:20%;">
      <img src="/assets/img/icon/gp.png" alt="google plus" class="icon auth"
data-url="https://accounts.google.com/o/oauth2/auth?client_id=<?=Config::get('my.gp_id')?>&response_type=code&scope=openid&redirect_uri=<?=Config::get('my.gp_callback')?>">
    </td>
    <td style="width:20%;"><img src="/assets/img/icon/power_0.png" id="del_cookie" class="icon"></td>
    <td style="width:20%;">
      <img src="/assets/img/icon/upload_0.png" alt="generate" class="icon" id="generate">
      <img src="/assets/img/icon/success.png" alt="success" class="icon" id="success" style="display:none;">
      <img src="/assets/img/icon/cross_big.png" alt="success" class="icon" id="delete" style="display:none;">
    </td>
  </tr>
</table>

<table>
<tr>
  <td> <a v-bind:href="'/follower/?u='+u_id">
    <span class="icon_num">{{follower}}</span>
    <img src="/assets/img/icon/people.png" class="icon">
  </a> </td>
  <td> <a v-bind:href="'/following/?u='+u_id">
    <span class="icon_num">{{following}}</span>
    <img src="/assets/img/icon/star_1.png" class="icon">
  </a> </td>
  <td>
    <span class="icon_num">{{nice}}</span>
    <img src="/assets/img/icon/thumbup_1.png" class="icon">
  </td>
  <td>
    <span class="icon_num">{{certify}}</span>
    <img src="/assets/img/icon/medal_1.png" class="icon">
  </td>
</tr>
</table>

<table id="rank"></table>

<table>
<tr>
  <td><img src="/assets/img/icon/circle_big.png" class="icon"></td>
  <td class="td_34" id="num_ratio">{{num_ratio}} % </td>
  <td><img src="/assets/img/icon/answer.png" class="icon"></td>
  <td class="td_34" id="num_answer">{{num_answer}}</td>
</tr>
</table>

<table>
<tr>
<td style="width:25%;">
  <a 
v-bind:href="'https://www.facebook.com/sharer.php?u=https://<?=Config::get('my.domain')?>/profile/?u='+u_id+'%26cpn=share_fb'"
target="_blank">
    <img src="/assets/img/icon/fb.jpg" alt="facebook" class="icon">
  </a>
</td>
<td style="width:25%;">
  <a 
v-bind:href="'https://twitter.com/intent/tweet?url=https://<?=Config::get('my.domain')?>/profile/?u='+u_id+'%26cpn=share_tw&text='+introduce+'+@quigen2015'"
target="_blank">
    <img src="/assets/img/icon/tw.jpg" alt="twitter" class="icon">
  </a>
</td>
<td style="width:25%;">
  <a 
v-bind:href="'line://msg/text/?'+introduce+'%0D%0Ahttps://<?=Config::get('my.domain')?>/profile/?u='+u_id+'%26cpn=share_ln'"
target="_blank" class="pc_disp_none">
    <img src="/assets/img/icon/ln.jpg" alt="line" class="icon">
  </a>
</td>
<td style="width:25%;">
  <a v-bind:href="'https://<?=Config::get('my.domain')?>/profile/?u='+u_id" target="_blank">
    <img src="/assets/img/icon/clip.png" alt="clip" class="icon">
  </a>
</td>
</tr>
</table>

<div id="ad"><iframe src="/htm/ad_blank/" width="320" height="50" frameborder="0" scrolling="no"></iframe></div>
<table>
  <tr>
  <td v-bind:class="answer"> <a href="/myprofile/">
    <img src="/assets/img/icon/answer.png" class="icon">
  </a> </td>
  <td v-bind:class="graph"> <a href="/myprofile/?list=graph">
    <img src="/assets/img/icon/bar-chart.png" class="icon">
  </a> </td>
  <td v-bind:class="forum"> <a href="/myprofile/?list=forum">
    <span class="icon_num">{{amt_forum}}</span>
    <img src="/assets/img/icon/list.png" class="icon">
  </a> </td>
  <td v-bind:class="msg"> <a href="/myprofile/?list=msg">
    <img src="/assets/img/icon/chat.png" class="icon">
  </a> </td>
  </tr>
</table>


<div class="div_t">
<template v-for="(d,k) in list_forum">
  <img v-bind:src="d['img']" class="icon">
  {{d['txt']}}
  <template v-if="d['no_param'] == 0">
  &nbsp; &nbsp; <a v-bind:href="'/forum/?f='+d['forum_id']"> >> </a>
  </template>
  <div style="width:100%;text-align:right;">{{d['open_time']}}</div>
</template>
</div>

<template v-for="(d,k) in list_graph">
<div class="graph_frame">
  <div class="graph_date">{{d['day']}}</div>
  <div class="graph_txt">{{d['answer']}}answer, spend {{d['time']}}</div>
</div>
<div class="graph_bar" v-bind:style="{ width: Math.round(d['answer']/max * 100) +'%' }">&nbsp;</div>
</template>

<table id="cel"></table>

</div>
<div id="ad_right"></div>

<script>
  var csrf = '<?=Model_Csrf::setcsrf()?>';
  var del = '<?=Config::get("lang.delete")?>';
  var no_ = '<?=Config::get("lang.no_")?>';
  var mon = '<?=Config::get("lang.mon")?>';
  var please_logout = '<?=Config::get("lang.please_logout")?>';
  var checked_mypage = '<?=Config::get("lang.checked_mypage")?>';
  var login = '<?=Config::get("lang.login")?>';
  var answer_first = '<?=Config::get("lang.answer_first")?>';
  var change_profile = '<?=Config::get("lang.change_profile")?>';
  var logout = '<?=Config::get("lang.logout")?>';
  var tag_category = '<?=Config::get("lang.tag_category")?>';
</script>
<script src="/assets/js/basic.js<?=Config::get("my.cache_v")?>"></script>
<script src="/assets/js/check_news.js<?=Config::get("my.cache_v")?>"></script>
<script src="/assets/js/myprofile.js<?=Config::get("my.cache_v")?>"></script>
<script>
  $(function(){ ga('send', 'pageview'); });
</script>

</body>

</html>

