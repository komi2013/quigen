<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8" />
    <title>admin</title>
    <link rel="shortcut icon" href="/assets/img/icon/quiz_generator.png" />
    <script src="/third/jquery-2.1.1.min.js"></script>
    <script src="/third/jquery.cookie.js"></script>
    <script>var ua = '<?=Config::get("my.ua")?>';</script>
    <script src="/assets/js/analytics.js?ver=55"></script>
    <link rel="stylesheet" type="text/css" href="/assets/css/basic.css?ver=55" />
    <link rel="stylesheet" href="/assets/css/pc.css?ver=55" media="only screen and (min-width : 711px)">
    <link rel="stylesheet" href="/assets/css/sp.css?ver=55" media="only screen and (max-width : 710px)">
    <meta name="viewport" content="width=device-width, user-scalable=no" >
  </head>
<body>
<table id="header">
  <td class="edge"><img src="/assets/img/icon/menu.png" alt="menu" class="icon" id="menu"></td>
  <td id="center">admin</td>
  <td class="edge">
    <img src="/assets/img/icon/cross_big.png" alt="generate" class="icon" id="delete">
    <img src="/assets/img/icon/success.png" alt="success" class="icon" id="success" style="display:none;">
  </td>
</table>
<?php
  $side = View::forge('side');
  $side->this_page = '';
  echo $side;
?>
<div id="content">
<table cellspacing="1" boroder="0">
    
<?php if( isset($question) ){ foreach($question as $k => $d){ ?>
<tr>
  <td>
    <a href="/quiz/?q=<?=$d['id']?>">
      <img src="<?=$d['img']?:'/assets/img/icon/no_img.png'?>" alt="quiz" class="icon">
    </a>
  </td>
  <td class="td_68_c">
    <a href="/quiz/?q=<?=$d['id']?>" style="text-decoration:none;">
      <?=Str::truncate(Security::htmlentities($d['txt']), 12)?>
    </a>
  </td>
  <td class="checkbox">
    <input type="checkbox" name="quiz_id" value="<?=$d['id']?>">
  </td>
</tr>
<?php }} ?>
</table>

<table cellspacing="1" boroder="0">
<?php if( isset($usr) ){ foreach($usr as $k => $d){ ?>
<tr>
  <td>
    <a href="/profile/?u=<?=$d['id']?>">
      <img src="<?=$d['img']?:'/assets/img/icon/no_img.png'?>" alt="usr" class="icon">
    </a>
  </td>
  <td class="question">
    <a href="/profile/?u=<?=$d['id']?>" style="text-decoration:none;">
      <?=Security::htmlentities($d['name'])?>
    </a>
  </td>
  <td class="checkbox">
    <input type="checkbox" name="usr_id" value="<?=$d['id']?>">
  </td>
</tr>
<?php }} ?>
</table>

<table cellspacing="1" boroder="0">
<?php if( isset($contact) ){ foreach($contact as $k => $d){ ?>
<tr>
  <td class="question"><?=Security::htmlentities($d['txt'])?></td>
  <td class="checkbox">
    <input type="checkbox" name="contact_id" value="<?=$d['id']?>">
  </td>
</tr>
<?php }} ?>
</table>

<br>
<table>
  <td class="td_33_c"><a href="/top/?page=<?=$page+1?>" style="text-decoration:none;"> << </a></td>
  <td class="td_33_c">||</td>
  <td class="td_33_c"><a href="/top/?page=<?=$page-1?>" style="text-decoration:none;"> >> </a></td>
</table>

<a href="/admin/?q=1">question</a>&nbsp;
<a href="/admin/?u=1">usr</a>&nbsp;
<a href="/admin/?com=1">usr</a>&nbsp;

</div>
<script>
  var csrf = '<?=Model_Csrf::setcsrf()?>';
</script>
<script src="/assets/js/check_news.js?ver=55"></script>
<script src="/assets/js/basic.js?ver=55"></script>
<script src="/assets/js/admin.js?ver=55"></script>
<script>
  ga('send', 'pageview');
</script>
</body>
</html>