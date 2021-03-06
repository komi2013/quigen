<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8" />
    <title><?=$title?></title>
    <meta name="description" content="<?=$q_txt?> <?=$description?>">
    <link rel="shortcut icon" href="/assets/img/icon/quiz_generator.png">
    <link rel="canonical" href="https://<?=Config::get('my.domain').'/quiz/?q='.$question?>" />
    <meta property="og:image" content="https://<?=$img ?: Config::get('my.domain').'/assets/img/icon/qg_big.png'?>" />
    <meta name="viewport" content="width=device-width, user-scalable=no" >
    <link rel="stylesheet" type="text/css" href="/assets/css/basic.css<?=Config::get("my.cache_v")?>" />
<?php if( isset($_GET['iframe']) ){?>
    <link rel="stylesheet" href="/assets/css/sp.css<?=Config::get("my.cache_v")?>">
<?php }else{ ?>
    <link rel="stylesheet" href="/assets/css/pc.css<?=Config::get("my.cache_v")?>" media="only screen and (min-width : 711px)">
    <link rel="stylesheet" href="/assets/css/sp.css<?=Config::get("my.cache_v")?>" media="only screen and (max-width : 710px)">
<?php } ?>
    <link rel="stylesheet" type="text/css" href="/assets/css/quiz.css<?=Config::get("my.cache_v")?>" />
  </head>
<body>

<?php
  $side = View::forge('side');
  $side->this_page = '';
  echo $side;
?>

<div style="position:absolute;top:-10000px;">
  <?php if($sound){ ?>
  <audio id="audio" controls><source src="<?=$sound?>"></audio>
  <?php } ?>
  <audio id="audio_correct" controls><source src="/assets/sound/effect/correct.mp3"></audio>
  <audio id="audio_incorrect" controls><source src="/assets/sound/effect/incorrect.mp3"></audio>
</div>

<div id="play">
<div id="content">
<div id="ad"><iframe src="/htm/ad_blank/" width="320" height="50" frameborder="0" scrolling="no"></iframe></div>
<?php if($img){?>
<div id="div_photo">
<img src="<?=$img?>" alt="quiz photo" id="photo">
</div>
<?php } ?>
<table><tr>
  <td id="question" class="td_99_box"><?=$q_txt?></td>
</tr></table>
<div id="big_result">
<img src="/assets/img/icon/circle_big.png" alt="correct" class="big_icon" id="big_correct" style="display:none;">
<img src="/assets/img/icon/cross_big.png" alt="incorrect" class="big_icon" id="big_incorrect" style="display:none;">

<?php if($question_type == 0) {?>
<table class="textbox"><tr><td class="txt_99" id="txt_answer" contenteditable='true'></td></tr></table>
<table class="textbox"><tr><td class="txt_99" id="correct" style="display:none;"><?=$correct?></td></tr></table>

<div class="textbox" style="width:98%;text-align:right;">
  <img src="/assets/img/icon/upload_0.png" alt="generate" class="icon" id="descriptive">
</div>

<table class="choice_q" >
  <tr><td class="choice cho_css" id="choice_0"><?=$arr_choice[0]?></td></tr>
  <tr><td class="choice cho_css" id="choice_1"><?=$arr_choice[1]?></td></tr>
  <tr><td class="choice cho_css" id="choice_2"><?=$arr_choice[2]?></td></tr>
  <tr><td class="choice cho_css" id="choice_3"><?=$arr_choice[3]?></td></tr>
</table>
<?php } else if ($question_type == 1) { ?>
<table class="textbox"><tr><td class="txt_99" id="correct" style="display:none;"><img src="<?=$correct?>"></td></tr></table>
<table><tr>
    <td class="choice cho_pic" id="choice_0"><img src="<?=$arr_choice[0]?>"></td>
    <td class="choice cho_pic" id="choice_1"><img src="<?=$arr_choice[1]?>"></td>
</tr><tr>
    <td class="choice cho_pic" id="choice_2"><img src="<?=$arr_choice[2]?>"></td>
    <td class="choice cho_pic" id="choice_3"><img src="<?=$arr_choice[3]?>"></td>
</tr></table>
<?php } ?>

</div>
<?php if($question_type == 0) {?>
<table class="alter_an">
  <tr>
  <td id="textbox" class="chg_an_type" an_type="text_an"> <img src="/assets/img/icon/textbox.png" class="icon"></td>
  <td id="choice_q" class="chg_an_type" an_type="choice_an"> <img src="/assets/img/icon/choice.png" class="icon"> </td>
  </tr>
</table>
<?php } ?>
<table>
<tr>
  <td class="td_15"><img src="/assets/img/icon/circle_big.png" alt="correct ratio" class="icon"></td>
  <td class="td_15" id="num_ratio">0 % </td>
  <td class="td_15"><img src="/assets/img/icon/answer.png" alt="amount of answer" class="icon"></td>
  <td class="td_15" id="num_answer">0</td>
  <td class="td_15"><a href="/htm/quest/" rel="nofollow" ><img src="/assets/img/icon/ticket.png" alt="ticket"></a></td>
  <td class="td_15" id="ticket" style="color:red;">0</td>
</tr>
</table>
<table>
<tr>
<?php $i=0; while($i<16){ ?>
  <?php if($i == 8){ ?>
    </tr><tr>
  <?php } ?>
  <td id="co_<?=$i?>" class="ans_u_correct"></td>
<?php ++$i;} ?>
</tr>
</table>

<table>
<tr>
<?php $i=0; while($i<16){ ?>
  <?php if($i == 8){ ?>
    </tr><tr>
  <?php } ?>
  <td id="inco_<?=$i?>" class="ans_u_incorrect"></td>
<?php ++$i;} ?>
</tr>
</table>

<span id="generator"></span> <span id="tag"></span>
<br>
<?php foreach ($arr_comment as $d) { ?>
  <div style="word-wrap:break-word;" class="comment"><?=$d['txt']?></div>
  <div class="div_right"><img src="<?=$d['u_img']?>" alt="u_img" class="icon" <?=$d['eto_css']?> ></div>
<?php } ?>
<textarea placeholder="comment" class="comment_input" id="comment_data"></textarea>
<div class="div_right">
<img src="/assets/img/icon/upload_0.png" alt="comment" class="icon" id="comment_add">
<img src="/assets/img/icon/success.png" alt="success" class="icon" id="success" style="display:none;">
</div>

<?php if($reference){ ?> 
<div style="word-wrap:break-word;">reference:<?=$reference?></div>
<?php } ?>
<table id="sns">
<tr>
<td style="width:70px;">
  <a href="<?=$fb_url?>" target="_blank">
    <img src="/assets/img/icon/fb.jpg" alt="facebook" class="icon">
  </a>
</td>
<td style="width:70px;">
  <a href="<?=$tw_url?>" target="_blank">
  <img src="/assets/img/icon/tw.jpg" alt="twitter" class="icon">
  </a>
</td>
<td style="width:70px;">
  <a href="<?=$ln_url?>" target="_blank" class="pc_disp_none">
  <img src="/assets/img/icon/ln.jpg" alt="line" class="icon">
  </a>
</td>
<td style="width:70px;">
  <a href="<?=$clip_url?>" target="_blank">
  <img src="/assets/img/icon/clip.png" alt="line" class="icon">
  </a>
</td>
</tr>
<tr>
  <td colspan="4" style="text-align:center;">
<textarea style="width:90%;"><iframe style="width: 100%;" src="https://<?=Config::get('my.domain')?>/quiz/?q=<?=$question?>&iframe=true" height="500" frameborder="0" scrolling="no"></iframe></textarea>
  </td>
</tr>
</table>

<table id="next_prev"></table>

</div>
<?php if( !isset($_GET['iframe']) ){?>
<div id="ad_right"></div>
</div>
<?php } ?>

    <script src="/third/jquery-2.1.1.min.js"></script>
    <script src="/third/jquery.cookie.js"></script>
    <script>var ua = '<?=Config::get("my.ua")?>';</script>
    <script src="/assets/js/analytics.js<?=Config::get("my.cache_v")?>"></script>
   
<script>
  var q_id = '<?=$question?>';
  var usr = '<?=$usr?>';
  var q_data = '<?=$q_data?>';
  var u_id = '<?=$u_id?>';
  var csrf = '<?=Model_Csrf::setcsrf()?>';
  var iframe = '<?=isset($_GET['iframe'])?>';
  var domain = '<?=Config::get('my.domain')?>';
  var no_ = '<?=Config::get("lang.no_")?>';
  var mon = '<?=Config::get("lang.mon")?>';
  var shared_quiz = '<?=Config::get("lang.shared_quiz")?>';
  var commented = '<?=Config::get("lang.commented")?>';
  var report = '<?=Config::get("lang.report")?>';
  var please_login = '<?=Config::get("lang.please_login")?>';
  var sound = '<?=$sound?>';
</script>
<script src="/assets/js/basic.js<?=Config::get("my.cache_v")?>"></script>
<script src="/assets/js/check_news.js<?=Config::get("my.cache_v")?>"></script>
<script src="/assets/js/quiz.js<?=Config::get("my.cache_v")?>"></script>

<script>
setTimeout(function(){
  ga('set', 'dimension7', iframe);
  $(function(){ ga('send', 'pageview'); });
},1000);
</script>

</body>
</html>

