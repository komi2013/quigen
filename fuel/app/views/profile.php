<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8" />
    <title><?=$usr_name?></title>
<?php if( $seo_index ){ ?>
    <meta name="description" content="<?=$meta_description?>、 フォロワー数：<?=$follower?>、 フォローしているユーザー数：<?=$following?>">
    <link rel="canonical" href="http://<?=Config::get('my.domain').'/profile/?u='.$_GET['u']?>" />
<?php } else { ?>
    <meta name="robots" content="noindex,follow">
<?php } ?>
    <link rel="shortcut icon" href="/assets/img/icon/quiz_generator.png">
    <script src="/third/jquery-2.1.1.min.js"></script>
    <script src="/third/jquery.cookie.js"></script>
    <meta property="og:image" content="http://<?=Config::get('my.domain').$usr_img?>" />
    <script>var ua = '<?=Config::get("my.ua")?>';</script>
    <script src="/assets/js/analytics.js?ver=81"></script>
    <link rel="stylesheet" type="text/css" href="/assets/css/basic.css?ver=81" />
    <link rel="stylesheet" href="/assets/css/pc.css?ver=81" media="only screen and (min-width : 711px)">
    <link rel="stylesheet" href="/assets/css/sp.css?ver=81" media="only screen and (max-width : 710px)">
    <meta name="viewport" content="width=device-width, user-scalable=no" >
  </head>
<body>

<table cellspacing="0" boroder="0" id="header">
  <td class="edge"><img src="/assets/img/icon/menu.png" alt="menu" class="icon" id="menu"></td>
  <td id="center" class="font_8 unread">プロファイル</td>
  <td class="edge" id="right">
    <img id="following1" src="/assets/img/icon/hourglass.png" class="icon" style="display:none;">
    <img id="following2" src="/assets/img/icon/star_1.png" class="icon" style="display:none;">
    <img id="following0" src="/assets/img/icon/star_0.png" class="icon" style="display:none;">
  </td>
</table>
<?php
  $side = View::forge('side');
  $side->this_page = '';
  echo $side;
?>
<div id="content">
<table>
  <tr>
  　<td id="photo_res"><img src="<?=$usr_img?>" class="icon" id="photo" <?=$css?> ></td>
  　<td id="name"><h1><?=$usr_name?></h1></td>
  </tr>
  <tr><td colspan="2" id="introduce" class="txt_long"><?=$introduce?></td></tr>
</table>

<?php if( !isset($_GET['list']) ){ ?>
<table style="border-collapse: collapse;">
<tr>
  <td class="td_68_c" style="text-align: center;"><a href="/category/">タグカテゴリ</a></td>
  <td class="td_15"><img src="/assets/img/icon/circle_big.png" class="icon"></td>
  <td class="td_15"><img src="/assets/img/icon/ranking.png" class="icon"></td>
</tr>
<?php if( isset($rank) ){ $i = 0; foreach($rank as $k => $d){  if($i < 5){ ?>
<tr>
  <td class="td_68_c"><a href="/search/?tag=<?=$d['tag']?>"><?=$d['tag']?></a></td>
  <td class="td_15"><?=$d['cnt']?></td>
  <td class="td_15"><?=$d['rank']?></td>
</tr>
<?php ++$i; } } } ?>
</table>
<?php } ?>
<table cellspacing="1" boroder="0">
<tr>
  <td><a href="/follower/?u=<?=$usr_id?>"><img src="/assets/img/icon/people.png" class="icon"></a></td>
  <td style="width:34%"><a href="/follower/?u=<?=$usr_id?>"><?=$follower?></a></td>
  <td><a href="/following/?u=<?=$usr_id?>"><img src="/assets/img/icon/star_1.png" class="icon"></a></td>
  <td style="width:34%"><a href="/following/?u=<?=$usr_id?>"><?=$following?></a></td>
</tr>
</table>

<table cellspacing="1" boroder="0">
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

<div id="ad"><iframe src="/htm/ad_blank/" width="320" height="50" frameborder="0" scrolling="no"></iframe></div>
<?php if( !isset($_GET['list']) ){ ?>
<table cellspacing="1" boroder="0"><tr>
  <td class="td_49" style="text-align: center;"><img src="/assets/img/icon/answer.png" class="icon"></td>
  <td class="td_50_c" style="text-align: center;"><a href="/profile/?u=<?=$_GET['u']?>&list=quiz"><img src="/assets/img/icon/quiz_generator.png" class="icon"></a></td>
</tr></table>
<?php }else{ ?>
<table cellspacing="1" boroder="0"><tr>
  <td class="td_50_c" style="text-align: center;"><a href="/profile/?u=<?=$_GET['u']?>"><img src="/assets/img/icon/answer.png" class="icon"></a></td>
  <td class="td_49" style="text-align: center;"><img src="/assets/img/icon/quiz_generator.png" class="icon"></td>
</tr></table>
<?php } ?>

<table id="cel"></table>
</div>
<script>
  var receiver = '<?=$usr_id?>'; 
  var u_id = '<?=$u_id?>';
  var status = '<?=$status?>';
  var list = '<?=isset($_GET['list']) ? 'quiz' : 'answer'; ?>';
  var csrf = '<?=Model_Csrf::setcsrf()?>';
</script>
<script src="/assets/js/basic.js?ver=81"></script>
<script src="/assets/js/check_news.js?ver=81"></script>
<script src="/assets/js/profile.js?ver=81"></script>
<script>
  $(function(){ ga('send', 'pageview'); });
</script>
</body>
</html>



