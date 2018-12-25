<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8" />
    <title><?=Config::get('my.top_title')?></title>
    <meta name="description" content="<?=Config::get('my.top_description')?>">
    <meta name="google-site-verification" content="<?=Config::get('my.sitemap')?>" />
    <meta name="yandex-verification" content="db2684568031d60c" />
    <link rel="shortcut icon" href="/assets/img/icon/quiz_generator.png" />
<?php if( $exactly_top ){ ?>
    <link rel="canonical" href="http://<?=Config::get("my.domain")?>/" />
<?php }else{ ?>
    <meta name="robots" content="noindex,follow">
<?php } ?>
    <script src="/third/jquery-2.1.1.min.js"></script>
    <script src="/third/jquery.cookie.js"></script>
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
  $side->this_page = 'top';
  echo $side;
?>

<div id="content">
<div class="img_input">
  <input type="text" list="tag_list" value="" maxlength="50" id="tag_name" class="input_with">
  <datalist id="tag_list"></datalist>
  <img src="/assets/img/icon/magnifier.png" alt="search" class="icon" id="search">
</div>
<div id="ad"><iframe src="/htm/ad_blank/" width="320" height="50" frameborder="0" scrolling="no"></iframe></div>
<table>
<?php
  $i = 0;
  $arr_answer = [];
  $prev_tag = '';
?>
<?php foreach($question as $k => $d){ ?>
<?php if( $exactly_top AND $prev_tag != $d['tag']){ ?>
    <tr><td colspan="100" class="td_99_c"><a href="/search/?tag=<?=$d['tag']?>"><?=$d['tag']?>(<?=$d['country']?>)</a></td></tr>
<?php } ?>    
<tr>
  <?php if($d['img']){ ?>
  <td colspan="15" class="td_15_t">
    <a href="/quiz/?q=<?=$d['id']?>"> <img src="<?=$d['img']?>" alt="quiz" class="icon"> </a>
  </td>
  <td colspan="85" class="td_84_t">
    <a href="/quiz/?q=<?=$d['id']?>" id="q_id_<?=$d['id']?>"> <?=$d['txt']?> </a>
  </td>
  <?php }else{ ?>
  <td colspan="100" class="td_99_t">
    <a href="/quiz/?q=<?=$d['id']?>" id="q_id_<?=$d['id']?>"> <?=$d['txt']?> </a>
  </td>
  <?php } ?>
</tr>
<?php
  ++$i;
  $arr_answer[] = $d['id'];
  $prev_tag = $d['tag'];
?>
<?php } ?>
</table>
<br>
<table>
  <tr>
  <td class="td_33">
    <?php if(!$exactly_top){ ?>
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
</div>
<div id="ad_right"></div>

<script>
  var arr_answer = JSON.parse( '<?= json_encode($arr_answer) ?>' );
  var mydomain = '<?=Config::get('my.domain')?>';
  var checked_top = '<?=Config::get('lang.checked_top')?>';
</script>
<script src="/assets/js/check_news.js<?=Config::get("my.cache_v")?>"></script>
<script src="/assets/js/basic.js<?=Config::get("my.cache_v")?>"></script>
<script src="/assets/js/top.js<?=Config::get("my.cache_v")?>"></script>

<script>
  $(function(){ $(function(){ ga('send', 'pageview'); }); });
</script>
</body>
</html>
