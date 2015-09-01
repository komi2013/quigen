<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8" />
    <title>クイジェン | FAQ</title>
    <meta name="description" content="数学や英語などのわからない部分の画像をアップすれば誰かが教えてくれるかも">
    <link rel="shortcut icon" href="/assets/img/icon/quiz_generator.png" />
<?php if( isset($_GET['page']) ){ ?>
    <meta name="robots" content="noindex,follow">
<?php }else{ ?>
    <link rel="canonical" href="http://<?=Config::get("my.domain")?>/" />
<?php } ?>
    <link rel="alternate" hreflang="ja" href="http://<?=Config::get("my.domain")?>/" />
    <script src="/third/jquery-2.1.1.min.js"></script>
    <script src="/third/jquery.cookie.js"></script>
    <script>var ua = '<?=Config::get("my.ua")?>';</script>
    <script src="/assets/js/analytics.js?ver=32"></script>
    <link rel="stylesheet" type="text/css" href="/assets/css/basic.css?ver=32" />
    <link rel="stylesheet" href="/assets/css/pc.css?ver=32" media="only screen and (min-width : 711px)">
    <link rel="stylesheet" href="/assets/css/sp.css?ver=32" media="only screen and (max-width : 710px)">
    <meta name="viewport" content="width=device-width, user-scalable=no" >
  </head>
<body>
<script src="/third/img-touch-canvas_1.js?ver=32"></script>

<table id="header">
  <td class="edge"><img src="/assets/img/icon/menu.png" alt="menu" class="icon" id="menu"></td>
  <td id="center"><h1 class="font_8 unread">画像掲示板</h1></td>
  <td class="edge"><img src="/assets/img/icon/magnifier.png" alt="search" class="icon" id="search"></td>
</table>
<?php
  $side = View::forge('side');
  $side->this_page = 'top';
  echo $side;
?>

<div id="content">

<table id="cel">
<?php $i = 0; $arr_answer = []; foreach($forum as $k => $d){  if($d['id']){ ?>
<tr>
  <?php if($d['img']){ ?>
  <td class="td_15_c<?= ($i==0)? ' attention':'' ?>" >
    <a href="/forum/?f=<?=$d['id']?>">
      <img src="<?=$d['img']?>" alt="question" class="icon<?= ($i==0)? ' attention':'' ?>">
    </a>
  </td>
  <td class="td_84_ct<?= ($i==0)? ' attention':'' ?>" >
    <a href="/forum/?f=<?=$d['id']?>">
      <input type="text" value="<?=Str::truncate(Security::htmlentities($d['txt']), 30)?>" readonly class="input_txt_c<?= ($i==0)? ' attention':'' ?>" id="q_id_<?=$d['id']?>">
    </a>
  </td>
  <?php }else{ ?>
  <td colspan="2" class="td_99_ct<?= ($i==0)? ' attention':'' ?>">
    <a href="/forum/?f=<?=$d['id']?>">
      <input type="text" value="<?=Str::truncate(Security::htmlentities($d['txt']), 30)?>" readonly class="input_txt_c<?= ($i==0)? ' attention':'' ?>" id="q_id_<?=$d['id']?>">
    </a>
  </td>
  <?php } ?>
</tr>
<?php ++$i; $arr_answer[] = $d['id']; } } ?>
</table>
<br>
<table>
  <tr>
  <td class="td_33">
    <?php if(!isset($top)){ ?>
    <a href="/forumlist/?page=<?=$page+1?>"> << </a>
    <?php }?>
  </td>
  <td class="td_33">||</td>
  <td class="td_33">
    <?php if($page > 2){ ?>
    <a href="/forumlist/?page=<?=$page-1?>"> >> </a>
    <?php }?>
  </td>
  </tr>
</table>
<?= View::forge('ad_load') ?>

<table style="text-align:center;">
<tr><td><textarea placeholder="Q." maxlength="400" class="txt_long" id="f_txt"></textarea></td></tr>
</table>
    
<table cellspacing="0">
  <tr>
  <td id="rotate" style="width:50px;cursor:pointer;"><img src="/assets/img/icon/rotate.png" class="icon" alt="rotate"></td>
  <td id="minus" style="width:50px;cursor:pointer;"><img src="/assets/img/icon/minus.png" class="icon" alt="minus"></td>
  <td id="plus" style="width:50px;cursor:pointer;"><img src="/assets/img/icon/plus.png" class="icon" alt="plus"></td>
  <td style="width:50px;cursor:pointer;">
    <select name='scale' style="font-size:20px;">
        <option>1</option>
        <option>5</option>
        <option>10</option>
        <option>20</option>
        <option>40</option>
    </select>
  </td>
  </tr>
</table>

<div id="canvas_div_img" style="text-align:center;">
<input type="file" id="imageLoader" name="imageLoader">
<canvas id="mycanvas" height="300" width="300"></canvas>
</div>

</div>

<script>
  var arr_answer = JSON.parse( '<?= json_encode($arr_answer) ?>' );
</script>
<script src="/assets/js/check_news.js?ver=32"></script>
<script src="/assets/js/basic.js?ver=32"></script>
<script src="/assets/js/forum_list.js?ver=32"></script>

</body>
</html>
