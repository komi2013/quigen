<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8" />
    <title><?=$usr_name?></title>
<?php if( $seo_index ){ ?>
    <meta name="description" content="<?=$meta_description?>, <?=$follower?> follower, <?=$following?> following user">
    <link rel="canonical" href="http://<?=Config::get('my.domain').'/profile/?u='.$_GET['u']?>" />
<?php } else { ?>
    <meta name="robots" content="noindex,follow">
<?php } ?>
    <link rel="shortcut icon" href="/assets/img/icon/quiz_generator.png">
    <script src="/third/jquery-2.1.1.min.js"></script>
    <script src="/third/jquery.cookie.js"></script>
    <meta property="og:image" content="http://<?=Config::get('my.domain').$usr_img?>" />
    <script>var ua = '<?=Config::get("my.ua")?>';</script>
    <script src="/assets/js/analytics.js?ver=91"></script>
    <link rel="stylesheet" type="text/css" href="/assets/css/basic.css?ver=91" />
    <link rel="stylesheet" href="/assets/css/pc.css?ver=91" media="only screen and (min-width : 711px)">
    <link rel="stylesheet" href="/assets/css/sp.css?ver=91" media="only screen and (max-width : 710px)">
    <meta name="viewport" content="width=device-width, user-scalable=no" >
  </head>
<body>

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
    <td>
      <span id="right">
        <img id="following1" src="/assets/img/icon/hourglass.png" class="icon" style="display:none;">
        <img id="following2" src="/assets/img/icon/star_1.png" class="icon" style="display:none;">
        <img id="following0" src="/assets/img/icon/star_0.png" class="icon" style="display:none;">
      </span>
    </td>
  </tr>
  <tr><td colspan="3" id="introduce" class="txt_long"><?=$introduce?></td></tr>
</table>

<?php if( !isset($_GET['list']) ){ ?>
<table style="border-collapse: collapse;">
<tr>
  <td class="td_68_c" style="text-align: center;">tag category</td>
  <td class="td_15"><img src="/assets/img/icon/circle_big.png" class="icon"></td>
  <td class="td_15"><img src="/assets/img/icon/ranking.png" class="icon"></td>
</tr>
<?php if( isset($rank) ){ $i = 0; foreach($rank as $k => $d){  if($i < 5){ ?>
<tr>
  <td class="td_68_c"><a href="/search/?tag=<?=$d['url_tag']?>"><?=$d['tag']?></a></td>
  <td class="td_15"><?=$d['cnt']?></td>
  <td class="td_15"><?=$d['rank']?></td>
</tr>
<?php ++$i; } } } ?>
</table>
<?php } ?>
<table cellspacing="1" boroder="0">
<tr>
  <td> <a href="/follower/?u=<?=$usr_id?>">
    <span class="icon_num"><?=$follower?></span>
    <img src="/assets/img/icon/people.png" class="icon">
  </a> </td>
  <td> <a href="/following/?u=<?=$usr_id?>">
    <span class="icon_num"><?=$following?></span>
    <img src="/assets/img/icon/star_1.png" class="icon">
  </a> </td>
  <td>
    <span class="icon_num"><?=$nice?></span>
    <img src="/assets/img/icon/thumbup_1.png" class="icon">
  </td>
  <td>
    <span class="icon_num"><?=$certify?></span>
    <img src="/assets/img/icon/medal_1.png" class="icon">
  </td>
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
<td style="width:70px;" class="pc_disp_none">
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
<table>
  <tr>
  <td class="<?= $list == '' ? 'this_page' : 'another_page' ?>"> <a href="/profile/?u=<?=$_GET['u']?>">
    <span class="icon_num"><?=$amt_answer?></span>
    <img src="/assets/img/icon/answer.png" class="icon">
  </a> </td>
  <td class="<?= $list == 'graph' ? 'this_page' : 'another_page' ?>"> <a href="/profile/?u=<?=$_GET['u']?>&list=graph">
    <img src="/assets/img/icon/bar-chart.png" class="icon">
  </a> </td>
  <td class="<?= $list == 'quiz' ? 'this_page' : 'another_page' ?>"> <a href="/profile/?u=<?=$_GET['u']?>&list=quiz">
    <span class="icon_num"><?=$amt_quiz?></span>
    <img src="/assets/img/icon/quiz_generator.png" class="icon">
  </a> </td>
  <td class="<?= $list == 'forum' ? 'this_page' : 'another_page' ?>"> <a href="/profile/?u=<?=$_GET['u']?>&list=forum">
    <span class="icon_num"><?=$amt_forum?></span>
    <img src="/assets/img/icon/pencil.png" class="icon">
  </a> </td>
  <td class="<?= $list == 'forum_comment' ? 'this_page' : 'another_page' ?>"> <a href="/profile/?u=<?=$_GET['u']?>&list=forum_comment">
    <span class="icon_num"><?=$amt_forum_comment?></span>
    <img src="/assets/img/icon/chat.png" class="icon">
  </a> </td>
  </tr>
</table>

<?php foreach($arr_list as $d ){?>
<div class="forum_txt" contenteditable="true"> <?=$d['txt']?> &nbsp; <?=$d['open_time']?></div>
<?php } ?>

<?php foreach($day as $d ){?>
<div class="graph_frame">
  <div class="graph_date"><?=$d['day']?></div>
  <?php if($d['answer']){?>
  <div class="graph_txt"><?=$d['answer']?>answer, spend <?=$d['time']?></div>
  <?php }?>
</div>
<div class="graph_bar" style="width:<?= round($d['answer']/$max * 100)  ?>%;">&nbsp;</div>
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
<script src="/assets/js/basic.js?ver=91"></script>
<script src="/assets/js/check_news.js?ver=91"></script>
<script src="/assets/js/profile.js?ver=91"></script>
<script>
  $(function(){ ga('send', 'pageview'); });
</script>
</body>
</html>



