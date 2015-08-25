<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8" />
    <title>クイジェン | 画像でやりとり掲示板</title>
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
    <script src="/assets/js/analytics.js?ver=31"></script>
    <link rel="stylesheet" type="text/css" href="/assets/css/basic.css?ver=31" />
    <link rel="stylesheet" href="/assets/css/pc.css?ver=31" media="only screen and (min-width : 711px)">
    <link rel="stylesheet" href="/assets/css/sp.css?ver=31" media="only screen and (max-width : 710px)">
    <meta name="viewport" content="width=device-width, user-scalable=no" >
  </head>
<body>

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
<table>
  <tr><td style="text-align: center;">
    <input type="text" list="tag_list" value="" maxlength="50" id="tag_name" class="txt_84">
    <datalist id="tag_list"></datalist>
  </td></tr>
</table>

<table id="cel">
<?php $i = 0; $arr_answer = []; foreach($question as $k => $d){  if($d['q_data']){ ?>
<tr>
  <?php if($d['img']){ ?>
  <td class="td_15_c<?= ($i==0)? ' attention':'' ?>" >
    <a href="/quiz/?crypt_q=<?=$d['q_data']?>">
      <img src="<?=$d['img']?>" alt="quiz" class="icon<?= ($i==0)? ' attention':'' ?>">
    </a>
  </td>
  <td class="td_84_ct<?= ($i==0)? ' attention':'' ?>" >
    <a href="/quiz/?crypt_q=<?=$d['q_data']?>">
      <input type="text" value="<?=Str::truncate(Security::htmlentities($d['txt']), 30)?>" readonly class="input_txt_c<?= ($i==0)? ' attention':'' ?>" id="q_id_<?=$d['id']?>">
    </a>
  </td>
  <?php }else{ ?>
  <td colspan="2" class="td_99_ct<?= ($i==0)? ' attention':'' ?>">
    <a href="/quiz/?crypt_q=<?=$d['q_data']?>">
      <input type="text" value="<?=Str::truncate(Security::htmlentities($d['txt']), 30)?>" readonly class="input_txt_c<?= ($i==0)? ' attention':'' ?>" id="q_id_<?=$d['id']?>">
    </a>
  </td>
  <?php } ?>
</tr>
<?php ++$i; $arr_answer[] = $d['id']; }} ?>
</table>
<br>
<table>
  <tr>
  <td class="td_33">
    <?php if(!isset($popular)){ ?>
    <a href="/top/?page=<?=$page+1?>"> << </a>
    <?php }?>
  </td>
  <td class="td_33">||</td>
  <td class="td_33">
    <?php if($page > 2){ ?>
    <a href="/top/?page=<?=$page-1?>"> >> </a>
    <?php }?>
  </td>
  </tr>
</table>
<?= View::forge('ad_load') ?>
</div>
<script>
  var arr_answer = JSON.parse( '<?= json_encode($arr_answer) ?>' );
</script>
<script src="/assets/js/check_news.js?ver=31"></script>
<script src="/assets/js/basic.js?ver=31"></script>
<script src="/assets/js/top.js?ver=31"></script>
</body>
</html>
