<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8" />
    <title><?=$title?></title>
    <?php if($noindex){?>
      <meta name="robots" content="noindex">
    <?php } ?>
    <meta name="description" content="<?=$description?>" >
    <link rel="shortcut icon" href="/assets/img/icon/quiz_generator.png" >
    <script src="/third/jquery-2.1.1.min.js"></script>
    <script src="/third/jquery.cookie.js"></script>
    <meta property="og:title" content="<?=$tag?>" />
    <meta property="og:url" content="<?='http://'.Config::get("my.domain").'/search/?tag='.urlencode($tag)?>" />

    <script>var ua = '<?=Config::get("my.ua")?>';</script>
    <script src="/assets/js/analytics.js?ver=84"></script>
    <link rel="stylesheet" type="text/css" href="/assets/css/basic.css?ver=84" />
    <link rel="stylesheet" href="/assets/css/pc.css?ver=84" media="only screen and (min-width : 711px)">
    <link rel="stylesheet" href="/assets/css/sp.css?ver=84" media="only screen and (max-width : 710px)">
    <meta name="viewport" content="width=device-width, user-scalable=no" >
  </head>
<body>

<?php
  $side = View::forge('side');
  $side->this_page = '';
  echo $side;
?>
<div id="content">
<div class="img_input">
  <input type="text" list="tag_list" value="<?=$tag?>" maxlength="50" id="tag_name" class="input_with">
  <datalist id="tag_list"></datalist>
  <img src="/assets/img/icon/magnifier.png" alt="search" class="icon" id="search">
</div>
<div class="tag_desc"><?=$tag?>(全<?=$cnt?>問)　<?=$description?></div>
<div id="ad"><iframe src="/htm/ad_blank/" width="320" height="50" frameborder="0" scrolling="no"></iframe></div>
<table id="cel">
<?php foreach($question as $k => $d){ ?>
<tr>
  <?php if($d['img']){ ?>
  <td colspan="15" class="td_15_t">
    <a href="/quiz/?q=<?=$d['id']?>"> <img src="<?=$d['img']?>" alt="quiz" class="icon"> </a>
  </td>
  <td colspan="85" class="td_84_t">
    <a href="/quiz/?q=<?=$d['id']?>"> <?=$d['txt']?> </a>
  </td>
  <?php }else{ ?>
  <td colspan="100" class="td_99_t">
    <a href="/quiz/?q=<?=$d['id']?>"> <?=$d['txt']?> </a>
  </td>
  <?php } ?>
</tr>
<?php } ?>
<?php if($left_cnt == $limit){ ?>
<tr><td colspan="100" class="td_99_c"><a href="/search/?tag=<?=$tag?>&page=<?=$next_page?>" target=”_blank”>・・・別ページで開く・・・</a></td></tr>
<?php } ?>
</table>
<div id="ad"><iframe src="/htm/ad_blank/" width="320" height="50" frameborder="0" scrolling="no"></iframe></div>
<span id="nextPage" style="display:none;"><?=$next_page?></span>
</div>
<div id="ad_right"></div>

<script>
  var tag = '<?=urlencode($tag)?>';
  tag = decodeURIComponent(tag);
  var nextPage = '<?=$next_page?>';
  var leftCnt = '<?=$left_cnt?>';
  var limit = '<?=$limit?>';
</script>
<script src="/assets/js/basic.js?ver=84"></script>
<script src="/assets/js/check_news.js?ver=84"></script>
<script src="/assets/js/search.js?ver=84"></script>
<script>
  ga('set', 'dimension7', '<?=$tag?>');
  $(function(){ ga('send', 'pageview'); });
</script>
</body>
</html>