<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8" />
    <title><?=$q_txt?></title>
    <link rel="shortcut icon" href="/assets/img/icon/quiz_generator.png">
    <link rel="canonical" href="http://<?=Config::get('my.domain').'/paidquiz/?q='.$question?>" />
    <script src="/third/jquery-2.1.1.min.js"></script>
    <script src="/third/jquery.cookie.js"></script>
    <meta property="og:title" content="<?=$q_txt?>" />
    <meta property="og:url" content="http://<?=Config::get('my.domain').'/paidquiz/?q='.$question?>" />
    <meta property="og:image" content="http://<?=$img ?: Config::get('my.domain').'/assets/img/icon/qg_big.png'?>" />
    <meta property="og:description" content="<?=$description?>" />
    <script>var ua = '<?=Config::get("my.ua")?>';</script>
    <script src="/assets/js/analytics.js?ver=67"></script>
    <link rel="stylesheet" type="text/css" href="/assets/css/basic.css?ver=67" />
    <link rel="stylesheet" href="/assets/css/pc.css?ver=67" media="only screen and (min-width : 711px)">
    <link rel="stylesheet" href="/assets/css/sp.css?ver=67" media="only screen and (max-width : 710px)">
    <meta name="viewport" content="width=device-width, user-scalable=no" >
  </head>
<body>

<table cellspacing="0" boroder="0" id="header">
  <td class="edge"><img src="/assets/img/icon/menu.png" alt="menu" class="icon" id="menu"></td>
  <td id="center" class="font_8 unread">クイジェン</td>
  <td class="edge" id="right"></td>
</table>
<?php
  $side = View::forge('side');
  $side->this_page = '';
  echo $side;
?>

<div id="content">
<?php if($img){?>
<img src="<?=$img?>" alt="quiz photo" id="photo">
<br>
<?php } ?>
<table><tr>
  <td id="question"><h1><?=$q_txt?></h1></td>
</tr></table>
<div id="big_result">
<img src="/assets/img/icon/circle_big.png" alt="correct" class="big_icon" id="big_correct" style="display:none;">
<img src="/assets/img/icon/cross_big.png" alt="incorrect" class="big_icon" id="big_incorrect" style="display:none;">
<table cellspacing="1" boroder="0">
  <tr><td class="choice" id="choice_0"><?=$arr_choice[0]?></td></tr>
  <tr><td class="choice" id="choice_1"><?=$arr_choice[1]?></td></tr>
  <tr><td class="choice" id="choice_2"><?=$arr_choice[2]?></td></tr>
  <tr><td class="choice" id="choice_3"><?=$arr_choice[3]?></td></tr>
</table>
</div>
<table cellspacing="1" boroder="0">
<tr>
  <td><img src="/assets/img/icon/circle_big.png" alt="correct ratio" class="icon"></td>
  <td class="num_txt" id="num_ratio">0 % </td>
  <td><img src="/assets/img/icon/answer.png" alt="amount of answer" class="icon"></td>
  <td class="num_txt" id="num_answer">0</td>
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
</div>
<script>
  var correct = '<?=$correct?>';
  var q_id = '<?=$question?>';
  var usr = '<?=$usr?>';
  var csrf = '<?=Model_Csrf::setcsrf()?>';
</script>
<script src="/assets/js/basic.js?ver=67"></script>
<script src="/assets/js/check_news.js?ver=67"></script>
<script src="/assets/js/paid_quiz.js?ver=67"></script>
<script>
  $(function(){ ga('send', 'pageview'); });
</script>
</body>
</html>
