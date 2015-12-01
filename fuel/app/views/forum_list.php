<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8" />
    <title><?=Config::get('my.forum_list_title')?></title>
    <meta name="description" content="<?=Config::get("my.forum_list_description")?>">
    <link rel="shortcut icon" href="/assets/img/icon/quiz_generator.png" />
<?php if( isset($top) ){  ?>    
    <link rel="canonical" href="http://<?=Config::get('my.domain').'/forumlist/'?>" />
<?php } ?>
<?php if( isset($_GET['page']) ){ ?>
    <meta name="robots" content="noindex,follow">
<?php } ?>
    <script src="/third/jquery-2.1.1.min.js"></script>
    <script src="/third/jquery.cookie.js"></script>
    <script>var ua = '<?=Config::get("my.ua")?>';</script>
    <script src="/assets/js/analytics.js?ver=45"></script>
    <link rel="stylesheet" type="text/css" href="/assets/css/basic.css?ver=45" />
    <link rel="stylesheet" href="/assets/css/pc.css?ver=45" media="only screen and (min-width : 711px)">
    <link rel="stylesheet" href="/assets/css/sp.css?ver=45" media="only screen and (max-width : 710px)">
    <meta name="viewport" content="width=device-width, user-scalable=no" >
  </head>
<body>
<script src="/third/img-touch-canvas_1.js?ver=45"></script>

<table id="header">
  <td class="edge"><img src="/assets/img/icon/menu.png" alt="menu" class="icon" id="menu"></td>
  <td id="center"><h1 class="font_8 unread">画像掲示板</h1></td>
  <td class="edge"></td>
</table>
<?php
  $side = View::forge('side');
  $side->this_page = 'forumlist';
  echo $side;
?>

<div id="content">

<table>
<?php $arr_forum = []; foreach($forum as $k => $d){ ?>
<tr>
  <?php if($d['img']){ ?>
  <td colspan="15" class="td_15">
    <a href="/forum/?f=<?=$d['id']?>">
      <img src="<?=$d['img']?>" alt="forum" class="icon">
    </a>
  </td>
  <td colspan="85" class="td_84">
    <a href="/forum/?f=<?=$d['id']?>" id="q_id_<?=$d['id']?>">
      <?=Str::truncate(Security::htmlentities($d['txt']), 30)?>
    </a>
  </td>

  <?php }else{ ?>
  <td colspan="100" class="td_99">
    <a href="/forum/?f=<?=$d['id']?>" id="q_id_<?=$d['id']?>">
      <?=Str::truncate(Security::htmlentities($d['txt']), 30)?>
    </a>
  </td>
  <?php } ?>
</tr>
<tr>
  <td colspan="33" class="td_33_t"></td>
  <td colspan="67" class="td_33_t">
  <img src="/assets/img/icon/thumbup_0.png" alt="like" id="f_img_<?=$d['id']?>" data-forum="<?=$d['id']?>" class="icon nice" style="cursor:pointer;">
  <span id="nice_<?=$d['id']?>"> <?=$d['nice']?> </span>
 </td>
</tr>
<?php $arr_forum[] = $d['id']; } ?>
</table>
<br>
<table>
  <tr>
  <td class="td_33">
    <?php if(!isset($top)){ ?>
    <a href="/forumlist/?page=<?=$page+1?>"> << </a>
    <?php }?>
  </td>
  <?php if( isset($top) AND $page > 2) {?>
  <td class="td_33">||</td>
  <?php } ?>
  <td class="td_33">
    <?php if($page > 2){ ?>
    <a href="/forumlist/?page=<?=$page-1?>"> >> </a>
    <?php }?>
  </td>
  </tr>
</table>

<table>
  <tr>
    <td style="width:84%;"></td>
    <td style="width:15%;">
      <img src="/assets/img/icon/upload_0.png" alt="submit" id="generate" class="icon">
      <img src="/assets/img/icon/success.png" alt="success" class="icon" id="success" style="display:none;">
    </td>
  </tr>
</table>
<table style="text-align:center;">
<tr><td><textarea placeholder="Q." maxlength="400" class="txt_long" id="txt"></textarea></td></tr>
</table>
    
<table>
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
<input type="file" id="imageLoader" name="imageLoader">
<canvas id="mycanvas" height="300" width="300"></canvas>
</div>

<?= View::forge('htm/ad_load') ?>
</div>

<?= View::forge('htm/ad_load_right') ?>

<script>
  var arr_forum = JSON.parse( '<?= json_encode($arr_forum) ?>' );
  var u_id = '<?=$u_id?>';
  var csrf = '<?=Model_Csrf::setcsrf()?>';
</script>
<script src="/assets/js/check_news.js?ver=45"></script>
<script src="/assets/js/basic.js?ver=45"></script>
<script src="/assets/js/forum_list.js?ver=45"></script>
<script>
  ga('send', 'pageview');
</script>
</body>
</html>
