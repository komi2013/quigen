<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8" />
    <title>マイアンサー(復習)</title>
    <link rel="shortcut icon" href="/assets/img/icon/quiz_generator.png" />
    <meta name="robots" content="noindex">
    <script src="/third/jquery-2.1.1.min.js"></script>
    <script src="/third/jquery.cookie.js"></script>
    <script>var ua = '<?=Config::get("my.ua")?>';</script>
    <script src="/assets/js/analytics.js?ver=78"></script>
    <link rel="stylesheet" type="text/css" href="/assets/css/basic.css?ver=78" />
    <link rel="stylesheet" href="/assets/css/pc.css?ver=78" media="only screen and (min-width : 711px)">
    <link rel="stylesheet" href="/assets/css/sp.css?ver=78" media="only screen and (max-width : 710px)">
    <meta name="viewport" content="width=device-width, user-scalable=no" >
  </head>
<body>

<table cellspacing="0" boroder="0" id="header">
  <td class="edge"><img src="/assets/img/icon/menu.png" alt="menu" class="icon" id="menu"></td>
  <td id="center"><h1 class="font_8 unread">マイアンサー</h1></td>
  <td class="edge"></td>
</table>
<?php
  $side = View::forge('side');
  $side->this_page = 'myanswer';
  echo $side;
?>
<div id="content">

<table>
<tr>
  <td class="td_68_c"><a href="/category/">タグカテゴリ</a></td>
  <td class="td_15"><img src="/assets/img/icon/circle_big.png" class="icon"></td>
  <td class="td_15"><img src="/assets/img/icon/ranking.png" class="icon"></td>
</tr>
<?php if (isset($rank) ){ $i = 0; foreach($rank as $k => $d){  if($i < 5){ ?>
<tr>
  <td class="td_68_c"><a href="/search/?tag=<?=$d['tag']?>"><?=$d['tag']?></a></td>
  <td class="td_15"><?=$d['cnt']?></td>
  <td class="td_15"><?=$d['rank']?></td>
</tr>
<?php ++$i; } } } ?>
</table>    

<table>
<tr>
  <td><img src="/assets/img/icon/circle_big.png" class="icon"></td>
  <td class="td_34" id="num_ratio">0 % </td>
  <td><img src="/assets/img/icon/answer.png" class="icon"></td>
  <td class="td_34" id="num_answer">0</td>
</tr>
</table>

<table>
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
  <img src="/assets/img/icon/clip.png" alt="clip" class="icon">
  </a>
</td>
</tr>
</table>

<div id="ad"></div>

<table id="cel"></table>
</div>

<div id="ad_right"></div>
<script>
var domain = '<?=Config::get('my.domain')?>';
</script>
<script src="/assets/js/check_news.js?ver=78"></script>
<script src="/assets/js/basic.js?ver=78"></script>
<script src="/assets/js/myanswer.js?ver=78"></script>
<script>
  $(function(){ ga('send', 'pageview'); });
</script>
</body>
</html>
