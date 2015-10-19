<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8" />
    <title>クイジェン | 大学受験の生物、日本史、世界史、英語の問題集</title>
    <meta name="description" content="ログインなしで4択クイズに答えれます。クイズの内容はセンター試験の内容もあります。ランクも表示されます。自分でもプライベートクイズを作成できます。復習機能で単語も覚えやすいです。">
    <link rel="shortcut icon" href="/assets/img/icon/quiz_generator.png" />
<?php if( $popular ){ ?>
    <link rel="canonical" href="http://<?=Config::get("my.domain")?>/" />
<?php }else{ ?>
    <meta name="robots" content="noindex,follow">
<?php } ?>
    <link rel="alternate" hreflang="ja" href="http://<?=Config::get("my.domain")?>/" />
    <script src="/third/jquery-2.1.1.min.js"></script>
    <script src="/third/jquery.cookie.js"></script>
    <script>var ua = '<?=Config::get("my.ua")?>';</script>
    <script src="/assets/js/analytics.js?ver=38"></script>
    <link rel="stylesheet" type="text/css" href="/assets/css/basic.css?ver=38" />
    <link rel="stylesheet" href="/assets/css/pc.css?ver=38" media="only screen and (min-width : 711px)">
    <link rel="stylesheet" href="/assets/css/sp.css?ver=38" media="only screen and (max-width : 710px)">
    <meta name="viewport" content="width=device-width, user-scalable=no" >
  </head>
<body>

<table id="header">
  <td class="edge"><img src="/assets/img/icon/menu.png" alt="menu" class="icon" id="menu"></td>
  <td id="center"><h1 class="font_8 unread">クイジェン</h1></td>
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
<?php $i = 0; $arr_answer = []; foreach($question as $k => $d){ ?>
<tr>
  <?php if($d['img']){ ?>
  <td colspan="15" class="td_15<?=!$popular ? '_t' : '' ?>">
    <a href="/quiz/?q=<?=$d['id']?>"> <img src="<?=$d['img']?>" alt="quiz" class="icon"> </a>
  </td>
  <td colspan="85" class="td_84<?=!$popular ? '_t' : '' ?>">
    <a href="/quiz/?q=<?=$d['id']?>" id="q_id_<?=$d['id']?>"> <?=$d['txt']?> </a>
  </td>
  <?php }else{ ?>
  <td colspan="100" class="td_99<?=!$popular ? '_t' : '' ?>">
    <a href="/quiz/?q=<?=$d['id']?>" id="q_id_<?=$d['id']?>"> <?=$d['txt']?> </a>
  </td>
  <?php } ?>
</tr>
<?php if( $popular ){ ?>
<tr>
  <td colspan="33" class="td_33_t"></td><td colspan="33" class="td_33_t"></td>
  <td colspan="34" class="td_33_t"><img src="/assets/img/icon/answer.png" alt="answer user" class="icon">&nbsp;<?=$d['a_amount']?></td>  
</tr>
<?php } ?>
<?php ++$i; $arr_answer[] = $d['id']; } ?>
</table>
<br>
<table>
  <tr>
  <td class="td_33">
    <?php if(!$popular){ ?>
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
<?= View::forge('htm/ad_load') ?>
</div>
<?= View::forge('htm/ad_load_right') ?>

<script>
  var arr_answer = JSON.parse( '<?= json_encode($arr_answer) ?>' );
</script>
<script src="/assets/js/check_news.js?ver=38"></script>
<script src="/assets/js/basic.js?ver=38"></script>
<script src="/assets/js/top.js?ver=38"></script>
</body>
</html>
