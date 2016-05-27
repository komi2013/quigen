<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8" />
    <title><?=$title?></title>
    <meta name="description" content="<?=$description?>">
    <link rel="shortcut icon" href="/assets/img/icon/quiz_generator.png">
    <link rel="canonical" href="http://<?=Config::get('my.domain').'/forum/?f='.$f_id?>" />
    <script src="/third/jquery-2.1.1.min.js"></script>
    <script src="/third/jquery.cookie.js"></script>
    <script>var ua = '<?=Config::get("my.ua")?>';</script>
    <script src="/assets/js/analytics.js?ver=74"></script>
    <meta property="og:image" content="http://<?=Config::get('my.domain').'/assets/img/icon/qg_big.png'?>" />
    <link rel="stylesheet" type="text/css" href="/assets/css/basic.css?ver=74" />
    <link rel="stylesheet" href="/assets/css/pc.css?ver=74" media="only screen and (min-width : 711px)">
    <link rel="stylesheet" href="/assets/css/sp.css?ver=74" media="only screen and (max-width : 710px)">
    <meta name="viewport" content="width=device-width, user-scalable=no" >
  </head>
<body>
<script src="/third/img-touch-canvas_1.js?ver=74"></script>    
    
<table cellspacing="0" boroder="0" id="header">
  <td class="edge"><img src="/assets/img/icon/menu.png" alt="menu" class="icon" id="menu"></td>
  <td id="center"><h1 class="unread font_8">FAQ</h1></td>
  <td class="edge"></td>
</table>
<?php
  $side = View::forge('side');
  $side->this_page = '';
  echo $side;
?>
<div id="content">

 <table>
<?php $arr_forum = []; foreach($forum as $k => $d){ ?>
  <?php if($d['img']){ ?>
  <tr> <td colspan="2" class="td_99" style="text-align:center;" > <img src="<?=$d['img']?>" alt="forum"> </td> </tr>
  <?php } if($d['txt']){ ?>
  <tr> <td colspan="2" class="td_99" > <?=$d['txt']?> </td> </tr>
  <?php } ?>
  <tr>
    <td>
      &nbsp; <img src="/assets/img/icon/thumbup_0.png" alt="like" id="f_img_<?=$d['id']?>" data-forum="<?=$d['id']?>" class="icon nice" style="cursor:pointer;">
      <span id="nice_<?=$d['id']?>"> <?=$d['nice']?> </span>
    </td>
    <td> <a href="/profile/?u=<?=$d['usr_id']?>"> <img src="<?=$d['u_img']?>" alt="usr" class="icon" <?=$d['eto_css']?>> </a> </td>
  </tr>
  <tr><td colspan="2" style="border-bottom: solid 0.1px #CCCCCC; height: 10px;"></td></tr>
<?php $arr_forum[] = $d['id']; } ?>
</table>
<br>
<table>
  <tr>
    <td style="width:84%;"></td>
    <td style="width:15%;">
      <img src="/assets/img/icon/upload_0.png" alt="submit" id="generate" class="icon">
      <img src="/assets/img/icon/success.png" alt="success" class="icon" id="success" style="display:none;">
    </td>
  </tr>
</table>
<div style="text-align:center;">
<textarea placeholder="A." maxlength="400" class="txt_long" id="txt"></textarea>
</div>
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
  var csrf = '<?=Model_Csrf::setcsrf()?>';
</script>
<script src="/assets/js/basic.js?ver=74"></script>
<script src="/assets/js/check_news.js?ver=74"></script>
<script src="/assets/js/forum.js?ver=74"></script>
<script>
  $(function(){ ga('send', 'pageview'); });
</script>
</body>
</html>

