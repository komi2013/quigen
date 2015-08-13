<?php
  $meta_description = 'カテゴリ一覧';
  foreach($arr_tag as $k => $d){
    $meta_description .= ','.Security::htmlentities($d['txt']);
  }
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8" />
    <title>カテゴリ</title>
    <meta name="description" content="<?=$meta_description?>">
    <link rel="shortcut icon" href="/assets/img/icon/quiz_generator.png" />
    <link rel="canonical" href="<?='http://'.Config::get("my.domain").'/category/'?>" />
    <script src="/third/jquery-2.1.1.min.js"></script>
    <script src="/third/jquery.cookie.js"></script>
    <script>var ua = '<?=Config::get("my.ua")?>';</script>
    <script src="/assets/js/analytics.js?ver=30"></script>
    <link rel="stylesheet" type="text/css" href="/assets/css/basic.css?ver=30" />
    <link rel="stylesheet" href="/assets/css/pc.css?ver=30" media="only screen and (min-width : 711px)">
    <link rel="stylesheet" href="/assets/css/sp.css?ver=30" media="only screen and (max-width : 710px)">
    <meta name="viewport" content="width=device-width, user-scalable=no" >
  </head>
<body>
<table id="header">
  <td class="edge"><img src="/assets/img/icon/menu.png" alt="menu" class="icon" id="menu"></td>
  <td id="center"><h1 class="font_8 unread">カテゴリ</h1></td>
  <td class="edge"></td>
</table>
<?php
  $side = View::forge('side');
  $side->this_page = 'category';
  echo $side;
?>
<div id="content">
<table id="cel">
<?php $i = 0; foreach($arr_tag as $k => $d){ ?>
<tr>
  <td class="td_99_c" >
    &nbsp;&nbsp;<a href="/category/?tag=<?=urlencode($d['txt'])?>">
      <input type="text" value="<?=Str::truncate(Security::htmlentities($d['txt']), 30)?>" readonly class="input_txt_c">
    </a>
  </td>
</tr>
<?php ++$i;} ?>
</table>
<?= View::forge('ad_load') ?>
</div>
<script src="/assets/js/check_news.js?ver=30"></script>
<script src="/assets/js/basic.js?ver=30"></script>
</body>
</html>