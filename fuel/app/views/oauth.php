<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8" />
    <title>login</title>
    <link rel="shortcut icon" href="/assets/img/icon/quiz_generator.png" />
    <meta name="robots" content="noindex">
    <script src="/third/jquery-2.1.1.min.js"></script>
    <script src="/third/jquery.cookie.js"></script>
    <script>var ua = '<?=Config::get("my.ua")?>';</script>
    <script src="/assets/js/analytics.js?ver=96"></script>
    <link rel="stylesheet" type="text/css" href="/assets/css/basic.css?ver=96" />
    <link rel="stylesheet" href="/assets/css/pc.css?ver=96" media="only screen and (min-width : 711px)">
    <link rel="stylesheet" href="/assets/css/sp.css?ver=96" media="only screen and (max-width : 710px)">
    <meta name="viewport" content="width=device-width, user-scalable=no" >
  </head>
<body>
<?php
  $side = View::forge('side');
  $side->this_page = 'myprofile';
  echo $side;
?>

<div id="content">
<div id="ad"><iframe src="/htm/ad_blank/" width="320" height="50" frameborder="0" scrolling="no"></iframe></div>
&nbsp;
</div>
<div id="ad_right"></div>
<div style="display: none;">
  <i id="myphoto"><?=$myphoto?></i><i id="myname"><?=$myname?></i><i id="introduce"><?=$introduce?></i>
  <?php foreach ($arr_offline_q as $k => $d){?>
    <div class="offline_q">
      <i id="q_txt_<?=$k?>"><?=$d[0]?></i>
      <i id="choice_0_<?=$k?>"><?=$d[1]?></i>
      <i id="choice_1_<?=$k?>"><?=$d[2]?></i>
      <i id="choice_2_<?=$k?>"><?=$d[3]?></i>
      <i id="choice_3_<?=$k?>"><?=$d[4]?></i>
      <i id="correct_choice_<?=$k?>"><?=$d[5]?></i>
      <i id="q_img_<?=$k?>"><?=$d[6]?></i>
      <i id="question_id_<?=$k?>"><?=$d[7]?></i>
      <i id="comment_<?=$k?>"><?=$d[8]?></i>
      <i id="myanswer_<?=$k?>"><?=$d[9]?></i>
      <i id="quiz_num_<?=$k?>"><?=$d[10]?></i>
    </div>
  <?php } ?>
  <?php foreach ($arr_offline_q as $k => $d){?>
  
  <?php } ?>
</div>
<script>

localStorage.follow = '<?=$follow?>';
localStorage.point = '<?=$point?>';
localStorage.ua_u_id = '<?=$u_id?>';
localStorage.answer_by_u = '<?=$js_answer_by_u?>';
localStorage.myname =  $('#myname').html();
localStorage.myphoto = $('#myphoto').html();
localStorage.introduce = $('#introduce').html();

var offline_q = [];
$(".offline_q").each(function(i){
  offline_q[i] = [
    $('#q_txt_'+i).html()
    ,$('#choice_0_'+i).html()
    ,$('#choice_1_'+i).html()
    ,$('#choice_2_'+i).html()
    ,$('#choice_3_'+i).html()
    ,$('#correct_choice_'+i).html()
    ,$('#q_img_'+i).html()
    ,$('#question_id_'+i).html()
    ,$('#comment_'+i).html()
    ,$('#myanswer_'+i).html()
    ,$('#quiz_num_'+i).html()
  ];
});

localStorage.offline_q = JSON.stringify(offline_q);

location.href = '/myprofile/ ';

</script>
<script src="/assets/js/basic.js?ver=96"></script>
<script>
  $(function(){ ga('send', 'pageview'); });
</script>
</body>
</html>

