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
    <script src="/assets/js/analytics.js?ver=96"></script>
    <link rel="stylesheet" type="text/css" href="/assets/css/basic.css?ver=96" />
    <link rel="stylesheet" href="/assets/css/pc.css?ver=96" media="only screen and (min-width : 711px)">
    <link rel="stylesheet" href="/assets/css/sp.css?ver=96" media="only screen and (max-width : 710px)">
    <meta name="viewport" content="width=device-width, user-scalable=no" >
  </head>
<body>
<script src="/third/img-touch-canvas_1.js?ver=96"></script>

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
<div class="trigger">
<table>
  <tr>
    <td> <a href="/profile/?u=<?=$d['usr_id']?>"> <img src="<?=$d['u_img']?>" class="icon" <?=$d['eto_css']?> > <?=$d['u_name']?> </a> </td>
    <td> <?=date('m-d H:i:s',strtotime($d['open_time']))?> </td>
  </tr>
</table>

<div class="forum_txt" contenteditable="true"> <?=$d['txt']?></div>
<div class="forum_img"><a href="/forum/?f=<?=$d['id']?>"><img src="<?=$d['img']?>"></a></div>
<?php if($d['view_all']){?>
<div class="div_100_c"><a href="/forum/?f=<?=$d['id']?>"> ... View All ... </a></div>
<?php } ?>
<div style="background-color:#F5F5F5;">
<?php if(!$d['no_param']){?>
<table>
  <tr>
    <td style="width:20%;border-width:0px;"></td>
    <td data-forum="<?=$d['id']?>"  data-f_u_id="<?=$d['usr_id']?>" class="nice param">
      <span class="icon_num" id="f_nice_amt_<?=$d['id']?>" <?php if($d['nice'] < 1){ ?> style="display:none;" <?php } ?> ><?=$d['nice']?></span>
      <img src="/assets/img/icon/thumbup_0.png" class="icon" id="f_nice_img_<?=$d['id']?>">
    </td>
    <td data-forum="<?=$d['id']?>" data-f_u_id="<?=$d['usr_id']?>" class="certify param">
      <span class="icon_num" id="f_certify_amt_<?=$d['id']?>" <?php if($d['certify'] < 1){ ?> style="display:none;" <?php } ?> ><?=$d['certify']?></span>
      <img src="/assets/img/icon/medal_0.png" class="icon" id="f_certify_img_<?=$d['id']?>">
    </td>
    <td class="param">
      <span class="icon_num" <?php if($d['comment_amt'] < 1){ ?> style="display:none;" <?php } ?>><?=$d['comment_amt']?></span>
      <a href="/forum/?f=<?=$d['id']?>"><img src="/assets/img/icon/pencil.png" class="icon f_menu"></a>
    </td>
  </tr>
</table>
<?php } ?>
<?php foreach($d['arr_comment'] as $k2 => $d2){ ?>
<div class="forum_comment" contenteditable="true">
  <span><?=$d2['txt']?></span>
  <a href="/forum/?f=<?=$d['id']?>" contenteditable="false"><img src="<?=$d2['img']?>" class="icon" ></a>
</div>
<?php } ?>
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
</script>
<script src="/assets/js/check_news.js?ver=96"></script>
<script src="/assets/js/basic.js?ver=96"></script>
<script src="/assets/js/forum_list.js?ver=96"></script>
<script src="/assets/js/forum_param.js?ver=96"></script>
<script>
  $(function(){ ga('send', 'pageview'); });
</script>
</body>
</html>
