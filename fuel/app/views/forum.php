<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8" />
    <title><?=$title?></title>
    <meta name="robots" content="noindex,nofollow">
    <meta name="description" content="<?=$description?>">
    <link rel="shortcut icon" href="/assets/img/icon/quiz_generator.png">
    <link rel="canonical" href="https://<?=Config::get('my.domain').'/forum/?f='.$f_id?>" />
    <script src="/third/jquery-2.1.1.min.js"></script>
    <script src="/third/jquery.cookie.js"></script>
    <script>var ua = '<?=Config::get("my.ua")?>';</script>
    <script src="/assets/js/analytics.js<?=Config::get("my.cache_v")?>"></script>
    <meta property="og:image" content="https://<?=Config::get('my.domain').'/assets/img/icon/qg_big.png'?>" />
    <link rel="stylesheet" type="text/css" href="/assets/css/basic.css<?=Config::get("my.cache_v")?>" />
    <link rel="stylesheet" href="/assets/css/pc.css<?=Config::get("my.cache_v")?>" media="only screen and (min-width : 711px)">
    <link rel="stylesheet" href="/assets/css/sp.css<?=Config::get("my.cache_v")?>" media="only screen and (max-width : 710px)">
    <meta name="viewport" content="width=device-width, user-scalable=no" >
  </head>
<body>
<script src="/third/img-touch-canvas_1.js<?=Config::get("my.cache_v")?>"></script>    
    
<?php
  $side = View::forge('side');
  $side->this_page = '';
  echo $side;
?>
<div id="content">

<?php foreach($arr_forum as $k => $d){ ?>
  <?php if($k < 1){ ?>
<table>
  <tr>
    <td> <a href="/profile/?u=<?=$d['usr_id']?>"> <img src="<?=$d['u_img']?>" class="icon" <?=$d['eto_css']?> > <?=$d['u_name']?> </a> </td>
    <td> <?=date('m-d H:i:s',strtotime($d['open_time']))?> </td>
  </tr>
</table>
  <?php } ?>
<div class="forum_txt"><?=$d['esc_txt']?></div>
<div class="forum_img"><img src="<?=$d['img']?>"></div>
<?php } ?>

<table>
  <tr>
    <td data-forum="<?=$d['id']?>" data-f_u_id="<?=$d['usr_id']?>" class="nice param">
      <span class="icon_num" id="f_nice_amt_<?=$d['id']?>" <?php if($forum_nice < 1){ ?> style="display:none;" <?php } ?> ><?=$forum_nice?></span>
      <img src="/assets/img/icon/thumbup_0.png" class="icon" id="f_nice_img_<?=$d['id']?>">
    </td>
    <td class="coin" fc_u_name="<?=$d['u_name']?>" fc_u_id="<?=$d['usr_id']?>"> <img src="/assets/img/icon/coin.png" class="icon"> </td>
    <td>
      <a href="<?=$fb_url?>" target="_blank">
        <img src="/assets/img/icon/fb.jpg" alt="facebook" class="icon">
      </a>
    </td>
    <td>
      <a href="<?=$tw_url?>" target="_blank">
      <img src="/assets/img/icon/tw.jpg" alt="twitter" class="icon">
      </a>
    </td>
    <td>
      <a href="<?=$clip_url?>" target="_blank">
      <img src="/assets/img/icon/clip.png" alt="line" class="icon">
      </a>
    </td>
  </tr>
</table>


<?php foreach($arr_comment as $k => $d){ ?>
<table>
  <tr>
    <td> <a href="/profile/?u=<?=$d['usr_id']?>"> <img src="<?=$d['u_img']?>" class="icon" <?=$d['eto_css']?> > <?=$d['u_name']?> </a> </td>
    <td> <?=date('m-d H:i:s',strtotime($d['open_time']))?> </td>
  </tr>
</table>
<div class="forum_txt">
    <?php if($d['point'] > 0){?>
      <div><img src="/assets/img/icon/coin.png" class="icon"> = <?=$d['point']?></div>
    <?php }?>
    <?=$d['esc_txt']?>
</div>
<div class="forum_img"><img src="<?=$d['img']?>"></div>
<table>
  <tr>
    <td style="width:48px;"></td>
    <td class="reply" fc_u_name="<?=$d['u_name']?>"> <img src="/assets/img/icon/reply.png" class="icon"> </td>
    <td data-comment="<?=$d['id']?>" data-fc_u_id="<?=$d['usr_id']?>" class="nice_c param">
      <span class="icon_num" id="fc_nice_amt_<?=$d['id']?>" <?php if($d['nice'] < 1){ ?> style="display:none;" <?php } ?> ><?=$d['nice']?></span>
      <img src="/assets/img/icon/thumbup_0.png" class="icon" id="fc_nice_img_<?=$d['id']?>">
    </td>
    <td class="coin" fc_u_name="<?=$d['u_name']?>" fc_u_id="<?=$d['usr_id']?>"> <img src="/assets/img/icon/coin.png" class="icon"> </td>
  </tr>
</table>
<?php } ?>

<div class="forum_form" id="txt" contenteditable="true" style='overflow: scroll;'></div>

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

</div>
<script>
  var arr_forum = [<?=$f_id?>];
  var arr_comment = JSON.parse( '<?=$js_comment_id?>' );
  var u_id = '<?=$u_id?>';
  var csrf = '<?=Model_Csrf::setcsrf()?>';
  var after = '<?=Config::get("lang.after")?>';
  var hours_please = '<?=Config::get("lang.hours_please")?>';
</script>
<script src="/assets/js/basic.js<?=Config::get("my.cache_v")?>"></script>
<script src="/assets/js/check_news.js<?=Config::get("my.cache_v")?>"></script>
<script src="/assets/js/forum.js<?=Config::get("my.cache_v")?>"></script>
<script src="/assets/js/forum_param.js<?=Config::get("my.cache_v")?>"></script>
<script>
  $(function(){ ga('send', 'pageview'); });
</script>
</body>
</html>

