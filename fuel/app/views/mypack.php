<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8" />
    <title>マイパック</title>
    <link rel="shortcut icon" href="/assets/img/icon/quiz_generator.png" />
    <meta name="robots" content="noindex">
    <script src="/third/jquery-2.1.1.min.js"></script>
    <script src="/third/jquery.cookie.js"></script>
    <script>var ua = '<?=Config::get("my.ua")?>';</script>
    <script src="/assets/js/analytics.js?ver=50"></script>
    <link rel="stylesheet" type="text/css" href="/assets/css/basic.css?ver=50" />
    <link rel="stylesheet" href="/assets/css/pc.css?ver=50" media="only screen and (min-width : 711px)">
    <link rel="stylesheet" href="/assets/css/sp.css?ver=50" media="only screen and (max-width : 710px)">
    <meta name="viewport" content="width=device-width, user-scalable=no" >
  </head>
<body>

<script src="/third/img-touch-canvas_1.js?ver=50"></script>

<table cellspacing="0" boroder="0" id="header">
  <td class="edge"><img src="/assets/img/icon/menu.png" alt="menu" class="icon" id="menu"></td>
  <td id="center"><h1 class="font_8 unread">マイパック</h1></td>
  <td class="edge">
    <?php if($q_amt < 20){ ?>
    <img src="/assets/img/icon/upload_0.png" alt="generate" class="icon" id="generate">
    <img src="/assets/img/icon/success.png" alt="success" class="icon" id="success" style="display:none;">
    <?php }else { ?>
    <img src="/assets/img/icon/success.png" alt="success" class="icon" id="success">
    <?php }?>
  </td>
</table>
<?php
  $side = View::forge('side');
  $side->this_page = '';
  echo $side;
?>
<div id="content">

<table><tr><td class="td_99_c"><input type="text" value="<?=Str::truncate(Security::htmlentities($pack_txt), 30)?>" readonly class="input_txt_c"></td></tr></table>

<table id="cel">
<?php foreach($arr_pack as $k => $d){ ?>
<tr>
  <td class="td_15_c">
    <a href="/paidquiz/?q=<?=$d['id']?>">
      <img src="<?=$d['img']?:'/assets/img/icon/quiz_generator.png'?>" alt="quiz" class="icon">
    </a>
  </td>
  <td class="td_84_c">
    <a href="/paidquiz/?q=<?=$d['id']?>">
      <input type="text" value="<?=Str::truncate(Security::htmlentities($d['txt']), 30)?>" readonly class="input_txt_c">
    </a>
  </td>
</tr>
<?php } ?>
</table>
<br>
<?php if($q_amt < 20){?>
<table id="question">
<tr><td><textarea placeholder="Q." maxlength="80" id="q_txt"></textarea></td></tr>

<tr><td><input type="text" placeholder="O" maxlength="20" class="choice" id="choice_0"></td></tr>
<tr><td><input type="text" placeholder="X" maxlength="20" class="choice" id="choice_1"></td></tr>
<tr><td><input type="text" placeholder="X" maxlength="20" class="choice" id="choice_2"></td></tr>
<tr><td><input type="text" placeholder="X" maxlength="20" class="choice" id="choice_3"></td></tr>
</table>

<table cellspacing="0">
  <tr>
  <td id="rotate" style="width:50px;"><img src="/assets/img/icon/rotate.png" class="icon" alt="rotate"></td>
  </tr>
</table>

<div style="text-align:center;">
<input type="file" id="imageLoader" name="imageLoader">
<canvas id="mycanvas" height="300" width="300"></canvas>
</div>
<?php }?>

<?= View::forge('htm/ad_load') ?>
</div>
<script>
  var pack_id = '<?=$_GET["p"]?>';
  var pack_txt = '<?=$pack_txt?>';
  var q_amt = '<?=$q_amt?>';
  var u_id = '<?=$u_id?>';
  var csrf = '<?=Model_Csrf::setcsrf()?>';
</script>
<script src="/assets/js/check_news.js?ver=50"></script>
<script src="/assets/js/basic.js?ver=50"></script>
<script src="/assets/js/mypack.js?ver=50"></script>
<script>
  ga('send', 'pageview');
</script>
</body>
</html>