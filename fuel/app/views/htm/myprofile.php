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
    <script src="https://www.gstatic.com/firebasejs/5.7.2/firebase.js"></script>
    <script>var ua = '<?=Config::get("my.ua")?>';</script>
    <script src="/assets/js/analytics.js<?=Config::get("my.cache_v")?>"></script>
    <link rel="stylesheet" type="text/css" href="/assets/css/basic.css<?=Config::get("my.cache_v")?>" />
    <link rel="stylesheet" href="/assets/css/pc.css<?=Config::get("my.cache_v")?>" media="only screen and (min-width : 711px)">
    <link rel="stylesheet" href="/assets/css/sp.css<?=Config::get("my.cache_v")?>" media="only screen and (max-width : 710px)">
    <meta name="viewport" content="width=device-width, user-scalable=no" >
  </head>
<body>
    <style>
        .logined {
            opacity:0.2;
        }
    </style>
<?php 
  $side = View::forge('side');
  $side->this_page = 'myprofile';
  echo $side;
?>

<div id="content">
<div class="img_input">
  <span id="photo_res"><img src="/assets/img/icon/camera.png" id="photo" class="icon" v-if="myphoto === ''"></span>
  <div style='display:inline-block;padding: 15px 0px 15px 0px;'>{{myname}}</div>
</div>

<div style="text-align:center;width:100%;">
  <textarea placeholder="introduce.." maxlength="120" id="introduce" class="txt_long">{{introduce}}</textarea>
</div>

<table>
  <tr>
    <td style="width:20%;">
      <img src="/assets/img/icon/fb.jpg" class="icon" v-bind:class="logined" v-if="(provider == 0 || provider == 1)"
data-url="https://www.facebook.com/dialog/oauth?client_id=<?=Config::get('my.fb_id')?>&redirect_uri=https://<?=$_SERVER['HTTP_HOST']?>/fboauth/">
    </td>
    <td style="width:20%">
      <img src="/assets/img/icon/tw.jpg" class="icon" v-bind:class="logined" v-if="(provider == 0 || provider == 2)" data-url="/twoauth/">
    </td>
    <td style="width:20%;">
      <img src="/assets/img/icon/gp.png" class="icon" v-bind:class="logined" v-if="(provider == 0 || provider == 3)"
data-url="https://accounts.google.com/o/oauth2/auth?client_id=<?=Config::get('my.gp_id')?>&response_type=code&scope=openid&redirect_uri=<?=Config::get('my.gp_callback')?>">
    </td>
    <td style="width:20%;" id="del_cookie" >
        <img v-if="provider" src="/assets/img/icon/power_2.png" class="icon">
        <img v-else-if="localStorage.ua_u_id" src="/assets/img/icon/power_1.png" class="icon">
        <img v-else src="/assets/img/icon/power_0.png" class="icon">
    </td>
    <td style="width:20%;">
      <img src="/assets/img/icon/upload_0.png" class="icon" id="generate">
      <img src="/assets/img/icon/success.png" class="icon" id="success" style="display:none;">
      <img src="/assets/img/icon/cross_big.png" class="icon" id="delete" style="display:none;">
    </td>
  </tr>
</table>

<table>
<tr>
  <td> <a v-bind:href="'/follower/?u='+u_id">
    <span class="icon_num" v-if="follower">{{follower}}</span>
    <img src="/assets/img/icon/people.png" class="icon">
  </a> </td>
  <td> <a v-bind:href="'/following/?u='+u_id">
    <span class="icon_num" v-if="following">{{following}}</span>
    <img src="/assets/img/icon/star_1.png" class="icon">
  </a> </td>
  <td>
    <span class="icon_num" v-if="nice">{{nice}}</span>
    <img src="/assets/img/icon/thumbup_1.png" class="icon">
  </td>
  <td>
    <span v-bind:class="point[2]" v-if="point[0]">{{ point[1] }}</span>
    <a href="/htm/exchange_point/"><img src="/assets/img/icon/coin.png" class="icon"></a>
  </td>
</tr>
</table>
<table v-if="list_rank.length > 0">
<tr>
  <td class="td_68_c"><?=Config::get('lang.tag_category')?></td>
  <td class="td_15"><img src="/assets/img/icon/circle_big.png" class="icon"></td>
  <td class="td_15"><img src="/assets/img/icon/ranking.png" class="icon"></td>
</tr>
<tr v-for="(d,k) in list_rank">
  <td class="td_68_c"><a v-bind:href="'/search/?tag='+d['tag']">{{d['tag']}}</a></td>
  <td class="td_15">{{d['cnt']}}</td>
  <td class="td_15">{{d['rank']}}</td>
</tr>
</table>
<table >
<tr>
  <td><img src="/assets/img/icon/circle_big.png" class="icon"></td>
  <td class="td_34" id="num_ratio">{{ answer_by_u[0] ? Math.round( answer_by_u[0] / answer_by_u[1] * 100 ) : 0 }} % </td>
  <td><img src="/assets/img/icon/answer.png" class="icon"></td>
  <td class="td_34" id="num_answer">{{answer_by_u[1]}}</td>
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
  <td v-on:click="list = 'answer'" v-bind:class="[list == 'answer' ? 'this_page' : 'another_page', '']">
    <span class="icon_num">{{offline_q.length}}</span>
    <img src="/assets/img/icon/answer.png" class="icon">
  </td>
  <td v-on:click="list = 'graph'" v-bind:class="[list == 'graph' ? 'this_page' : 'another_page', '']">
    <img src="/assets/img/icon/bar-chart.png" class="icon">
  </td>
  <td v-on:click="list = 'forum'" v-bind:class="[list == 'forum' ? 'this_page' : 'another_page', '']">
    <span class="icon_num">{{amt_forum}}</span>
    <img src="/assets/img/icon/list.png" class="icon">
  </td>
  <td v-on:click="list = 'msg'" v-bind:class="[list == 'msg' ? 'this_page' : 'another_page', '']">
    <span class="icon_num">{{amt_msg}}</span>
    <img src="/assets/img/icon/chat.png" class="icon">
  </td>
  </tr>
</table>
<template v-if="list == 'answer'">
    <table><tr>
        <td id="position" class="td_99_c" style="color: blue;">previous offline quiz</td>
    </tr></table>
    <table>
    <template v-for="(d,k) in offline_q">
    <tr v-bind:class="'del_'+d[7]">
        <td colspan="100" class="td_84" v-bind:id="'position_'+d[7]">
            <a v-bind:href="'/quiz/?q='+d[7]">
                <img v-if="d[5] == d[9]" src="/assets/img/icon/circle_big" class="icon result">
                <img v-else src="/assets/img/icon/cross_big.png" class="icon result">
                {{ d[0] }}
            </a>
        </td>
    </tr>
    <tr v-bind:class="'del_'+d[7]">
        <td colspan="50" class="td_49_t">
            <img src="/assets/img/icon/no_internet.png" class="icon goOffline" v-bind:q_id="d[7]">
        </td>
        <td colspan="50" class="td_50_t">
            <img src="/assets/img/icon/trash.png" class="icon delAnswer" v-bind:q_id="d[7]">
        </td>
    </tr>
    </template>
    </table>
</template>
<template v-if="list == 'graph'">
<table><tr>
    <td style="width:35%"><img src="/assets/img/icon/calendar.png"></td>
    <td><img src="/assets/img/icon/answer.png"></td>
    <td><img src="/assets/img/icon/hourglass.png"></td>
</tr></table>
<template v-for="(d,k) in list_graph">
<div class="graph_frame">
  <div class="graph_date" style="width:40%">{{d['day']}}</div>
  <div class="graph_txt" style="width:10%">{{d['answer']}}</div>
  <div class="graph_txt">{{d['time']}}</div>
</div>
<div class="graph_bar" v-bind:style="{ width: Math.round(d['answer']/max * 100) +'%' }">&nbsp;</div>
</template>
</template>

<template v-if="list == 'forum'" v-for="(d,k) in list_forum">
<div class="div_t" v-on:click="goDetail(d['forum_id'],d['question_id'])">
  <div style="width:100%;text-align:right;">{{d['open_time']}}</div>
  <span v-html="d['txt']"></span>
  <img v-if="d['img']" v-bind:src="d['img']" class="icon">
</div>
</template>

<table v-if="list == 'msg'">
  <tr v-for="(d,k) in list_msg">
    <td class='td_15'><a v-bind:href="'/profile/?u='+d['usr_id']+'&list=msg'"><img v-bind:src="d['u_img']" class="icon"></a></td>
    <td><a v-bind:href="'/profile/?u='+d['usr_id']+'&list=msg'">{{ d['last_txt'] }}</a></td>
  </tr>
</table>

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
  var please_login = '<?=Config::get("lang.please_login")?>';
  var change_profile = '<?=Config::get("lang.change_profile")?>';
  var logout = '<?=Config::get("lang.logout")?>';
  var tag_category = '<?=Config::get("lang.tag_category")?>';
  // Initialize Firebase
  var config = {
    apiKey: "AIzaSyAv7c9wh78dRtJ_bmfvLyAAvpLNYyM_6-M",
    authDomain: "first-c2036.firebaseapp.com",
    databaseURL: "https://first-c2036.firebaseio.com",
    projectId: "first-c2036",
    storageBucket: "first-c2036.appspot.com",
    messagingSenderId: "289998193190"
  };
  firebase.initializeApp(config);
  const messaging = firebase.messaging();
  messaging.usePublicVapidKey("BD_N3qR5bZuczRat6fJwWFTKIEalOXbm6o6ALYMiLPkFqaTmXLiyOum5SZpSjScWfPMGA29nzuzWUqKCYNt7M2c");

</script>
<script src="/assets/js/basic.js<?=Config::get("my.cache_v")?>"></script>
<script src="/assets/js/check_news.js<?=Config::get("my.cache_v")?>"></script>
<script src="/assets/js/myprofile.js<?=Config::get("my.cache_v")?>"></script>
<script>
  $(function(){ ga('send', 'pageview'); });
</script>

</body>

</html>

