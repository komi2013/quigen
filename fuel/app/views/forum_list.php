<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8" />
    <title><?=Config::get('my.forum_list_title')?></title>
    <meta name="description" content="<?=Config::get("my.forum_list_description")?>">
    <link rel="shortcut icon" href="/assets/img/icon/quiz_generator.png" />
<?php if( isset($_GET['page']) ){ ?>
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
<script src="/third/img-touch-canvas_1.js<?=Config::get("my.cache_v")?>"></script>

<?php
  $side = View::forge('side');
  $side->this_page = 'forumlist';
  echo $side;
?>

<div id="content">

<div class="forum_form" id="txt" contenteditable="true"></div>

<table><tr>
  <td class="td_33">
    <input type="file" id="file_load" >
    <img src="/assets/img/icon/camera.png" class="icon" id="camera">
  </td>
  <td class="td_33"><img src="/assets/img/icon/happy.png" class="icon" id="emoji_show"></td>
  <td class="td_33">
    <img src="/assets/img/icon/upload_0.png" alt="submit" id="generate" class="icon">
    <img src="/assets/img/icon/success.png" alt="success" class="icon" id="success" style="display:none;">
  </td>
</tr></table>

<table style="display:none;" id="canvas_menu">
  <tr>
  <td id="rotate" style="width:50px;cursor:pointer;"><img src="/assets/img/icon/rotate.png" class="icon" alt="rotate"></td>
  <td id="minus" class="sp_disp_none" style="width:50px;cursor:pointer;"><img src="/assets/img/icon/minus.png" class="icon" alt="minus"></td>
  <td id="plus" class="sp_disp_none" style="width:50px;cursor:pointer;"><img src="/assets/img/icon/plus.png" class="icon" alt="plus"></td>
  <td class="sp_disp_none" style="width:50px;cursor:pointer;">
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

<canvas id="mycanvas1" height="300" width="300"></canvas>
</div>

<div id="emoji_list" style="display:none;">
  <?php foreach(Model_Emoji::$table as $k => $d){ ?>
    <?=$d?>
  <?php } ?>
</div>
<div id="timeline_frame">
<?php foreach($arr_forum as $k => $d){ ?>
<div class="trigger" style="padding: 0px 0px 30px 0px;">

<div style="display:inline-block;"> <a href="/profile/?u=<?=$d['usr_id']?>"> <img src="<?=$d['u_img']?>" class="icon" <?=$d['eto_css']?> > </a> </div>
<div style="display:inline-block;text-align:right;vertical-align:bottom;"> <?=date('M/jS',strtotime($d['open_time']))?> </div>
<div f-id="<?=$d['id']?>" q-id="<?=$d['question_id']?>" class="goDetail">
<div class="forum_txt" contenteditable="true"> <?=$d['txt']?></div>
<?php if($d['img']){ ?>
<div class="forum_img"><a><img src="<?=$d['img']?>"></a></div>
<?php }?>
<?php if($d['view_all']){?>
<div class="div_100_c"><a> ... View All ... </a></div>
<?php } ?>
<div style="background-color:#F5F5F5;">
<?php foreach($d['arr_comment'] as $k2 => $d2){ ?>
<div class="forum_comment" contenteditable="true">
  <span><?=$d2['txt']?></span>
  <?php if($d2['img']){ ?>
  <img src="<?=$d2['img']?>" class="icon" >
  <?php } ?>
</div>
<?php } ?>
</div>
</div>
</div>
<?php } ?>

</div>
<?php if($next_page){ ?> <div colspan="100" class="div_100_c"><a href="/forumlist/?page=<?=$next_page?>" target=”_blank”>* * open another page * *</a></div> <?php } ?>
<span id="nextPage" style="display:none;"><?=$next_page?></span> 
<div id="ad"><iframe src="/htm/ad_blank/" width="320" height="50" frameborder="0" scrolling="no"></iframe></div>
<table>
  <tr><td class="td_99_c"><a href="https://www.youtube.com/watch?v=ZQlq1a-jPHw" target="_blank">how to use(video)</a></td></tr>
  <tr><td class="td_99_c"><a href="http://quizgenerator-help.hatenadiary.jp/archive/2015" target="_blank">how to use(blog)</a></td></tr>
  <tr><td class="td_99_c"><a href="/htm/rule/">rule</a></td></tr>
</table>

</div>

<div id="ad_right"></div>

<script>
  var arr_forum = JSON.parse( '<?=$js_forum_id?>' );
  var u_id = '<?=$u_id?>';
  var nextPage = '<?=$next_page?>';
  var csrf = '<?=Model_Csrf::setcsrf()?>';
  var checked_chat = '<?=Config::get("lang.checked_chat")?>';
</script>
<script src="/assets/js/check_news.js<?=Config::get("my.cache_v")?>"></script>
<script src="/assets/js/basic.js<?=Config::get("my.cache_v")?>"></script>
<script src="/assets/js/forum_list.js<?=Config::get("my.cache_v")?>"></script>
<script src="/assets/js/forum_param.js<?=Config::get("my.cache_v")?>"></script>
<script>
  $(function(){ ga('send', 'pageview'); });
</script>
</body>
</html>
