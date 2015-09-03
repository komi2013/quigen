<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8" />
    <title>FAQ | 数学や英語などのわからない部分の画像をアップすれば教えてくれるかも</title>
    <meta name="description" content="わからない所が教科書や問題集にあった場合その画像をアップすれば他に見ている誰かが教えてくれるかも、簡単に画像を投稿できるんでためしにアップしてみては？">
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
    <script src="/assets/js/analytics.js?ver=33"></script>
    <link rel="stylesheet" type="text/css" href="/assets/css/basic.css?ver=33" />
    <link rel="stylesheet" type="text/css" href="/assets/css/forum_list.css?ver=33" />
    <link rel="stylesheet" href="/assets/css/pc.css?ver=33" media="only screen and (min-width : 711px)">
    <link rel="stylesheet" href="/assets/css/sp.css?ver=33" media="only screen and (max-width : 710px)">
    <meta name="viewport" content="width=device-width, user-scalable=no" >
  </head>
<body>
<script src="/third/img-touch-canvas_1.js?ver=33"></script>

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
  <td class="td_15">
    <a href="/forum/?f=<?=$d['id']?>">
      <img src="<?=$d['img']?>" alt="forum" class="icon">
    </a>
  </td>
  <td style="width:68%;">
    <a href="/forum/?f=<?=$d['id']?>">
      <input type="text" value="<?=Str::truncate(Security::htmlentities($d['txt']), 30)?>" readonly class="input_txt" id="q_id_<?=$d['id']?>">
    </a>
  </td>
  <td class="td_15"> <a href="/forum/?f=<?=$d['id']?>"> >></a> </td>
  <?php }else{ ?>
  <td colspan="2" style="width:99%;">
    <a href="/forum/?f=<?=$d['id']?>">
      <input type="text" value="<?=Str::truncate(Security::htmlentities($d['txt']), 30)?>" readonly class="input_txt" id="q_id_<?=$d['id']?>">
    </a>
  </td>
  <td class="td_15"> <a href="/forum/?f=<?=$d['id']?>"> >></a> </td>
  <?php } ?>
</tr>
<tr>
  <td colspan="3">
  &nbsp; <img src="/assets/img/icon/thumbup_0.png" alt="like" id="f_img_<?=$d['id']?>" data-forum="<?=$d['id']?>" class="icon nice" style="cursor:pointer;">
  <span id="nice_<?=$d['id']?>"> <?=$d['nice']?> </span>
 </td>
</tr>
<tr><td colspan="3" style="border-bottom: solid 0.1px #CCCCCC; height: 10px;"></td></tr>
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
  <td class="td_33">||</td>
  <td class="td_33">
    <?php if($page > 2){ ?>
    <a href="/forumlist/?page=<?=$page-1?>"> >> </a>
    <?php }?>
  </td>
  </tr>
</table>
<?= View::forge('ad_load') ?>

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

</div>

<script>
  var arr_forum = JSON.parse( '<?= json_encode($arr_forum) ?>' );
  var u_id = '<?=$u_id?>';
</script>
<script src="/assets/js/check_news.js?ver=33"></script>
<script src="/assets/js/basic.js?ver=33"></script>
<script src="/assets/js/forum_list.js?ver=33"></script>

</body>
</html>
