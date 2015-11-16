<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8" />
    <title><?=$q_txt?></title>
    <meta name="description" content="<?=$q_txt?> <?=$description?>">
    <link rel="shortcut icon" href="/assets/img/icon/quiz_generator.png">
    <link rel="canonical" href="http://<?=Config::get('my.domain').'/quiz/?q='.$question?>" />
    <script src="/third/jquery-2.1.1.min.js"></script>
    <script src="/third/jquery.cookie.js"></script>
    <link rel="stylesheet" type="text/css" href="/assets/css/quiz.css?ver=43" />
    <script>var ua = '<?=Config::get("my.ua")?>';</script>
    <script src="/assets/js/analytics.js?ver=43"></script>
    <meta property="og:image" content="http://<?=$img ?: Config::get('my.domain').'/assets/img/icon/qg_big.png'?>" />
    <link rel="stylesheet" type="text/css" href="/assets/css/basic.css?ver=43" />
    <link rel="stylesheet" href="/assets/css/pc.css?ver=43" media="only screen and (min-width : 711px)">
    <link rel="stylesheet" href="/assets/css/sp.css?ver=43" media="only screen and (max-width : 710px)">
    <meta name="viewport" content="width=device-width, user-scalable=no" >
  </head>
<body>
    
    
<table cellspacing="0" boroder="0" id="header">
  <td class="edge"><img src="/assets/img/icon/menu.png" alt="menu" class="icon" id="menu"></td>
  <td id="center"><h1 class="unread font_8">クイジェン</h1></td>
  <td class="edge" id="right"></td>
</table>
<?php
  $side = View::forge('side');
  $side->this_page = '';
  echo $side;
?>
<div id="content">
<?php if($img){?>
<div id="div_photo">
<img src="<?=$img?>" alt="quiz photo" id="photo">
</div>
<?php } ?>
<table><tr>
  <td id="question" class="td_99_t"><?=$q_txt?></td>
</tr></table>
<div id="big_result">
<img src="/assets/img/icon/circle_big.png" alt="correct" class="big_icon" id="big_correct" style="display:none;">
<img src="/assets/img/icon/cross_big.png" alt="incorrect" class="big_icon" id="big_incorrect" style="display:none;">
<table>
  <tr><td class="choice" id="choice_0"><?=$arr_choice[0]?></td></tr>
  <tr><td class="choice" id="choice_1"><?=$arr_choice[1]?></td></tr>
  <tr><td class="choice" id="choice_2"><?=$arr_choice[2]?></td></tr>
  <tr><td class="choice" id="choice_3"><?=$arr_choice[3]?></td></tr>
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
  <a href="<?=$ln_url?>" target="_blank">
  <img src="/assets/img/icon/ln.jpg" alt="line" class="icon">
  </a>
</td>
<td style="width:70px;">
  <a href="<?=$clip_url?>" target="_blank">
  <img src="/assets/img/icon/clip.png" alt="line" class="icon">
  </a>
</td>
</tr>
</table>
<br>
<table>
<?php foreach ($arr_comment as $d) { ?>
<tr>
  <td><?=$d['txt']?></td>
  <td><img src="<?=$d['u_img']?>" alt="u_img" class="icon" <?=$d['eto_css']?> ></td>
</tr>
<?php } ?>
<tr>
  <td><input type="text" placeholder="コメント" class="txt_84" id="comment_data"></td>
  <td>
    <img src="/assets/img/icon/upload_0.png" alt="comment" class="icon" id="comment_add">
    <img src="/assets/img/icon/success.png" alt="success" class="icon" id="success" style="display:none;">
  </td>
</tr>
</table>

<div style="word-wrap:break-word;">引用元:<?=$reference?></div>


<table>
<tr>
<td style="width:98%;text-align:right;">
  <a href="#" id="report">
    <img src="/assets/img/icon/exclamation.png" alt="report" class="icon">
  </a>
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
<?= View::forge('htm/ad_load') ?>
</div>
<?= View::forge('htm/ad_load_right') ?>


<script>
  var correct = '<?=$correct?>';
  var q_id = '<?=$question?>';
  var usr = '<?=$usr?>';
  var q_data = '<?=$q_data?>';
  var u_id = '<?=$u_id?>';
  var csrf = '<?=Model_Csrf::setcsrf()?>';
</script>
<script src="/assets/js/basic.js?ver=43"></script>
<script src="/assets/js/check_news.js?ver=43"></script>
<script src="/assets/js/quiz.js?ver=43"></script>
<script>
setTimeout(function(){
  ga('send', 'pageview');
},1000);
</script>

</body>
</html>

