<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8" />
    <title>有料クイズ</title>
    <link rel="shortcut icon" href="/assets/img/icon/quiz_generator.png" />
    <meta name="robots" content="noindex">
    <script src="/third/jquery-2.1.1.min.js"></script>
    <script src="/third/jquery.cookie.js"></script>
    <script>var ua = '<?=Config::get("my.ua")?>';</script>
    <script src="/assets/js/analytics.js?ver=39"></script>
    <link rel="stylesheet" type="text/css" href="/assets/css/basic.css?ver=39" />
    <link rel="stylesheet" href="/assets/css/pc.css?ver=39" media="only screen and (min-width : 711px)">
    <link rel="stylesheet" href="/assets/css/sp.css?ver=39" media="only screen and (max-width : 710px)">
    <meta name="viewport" content="width=device-width, user-scalable=no" >
  </head>
<body>
<link rel="stylesheet" type="text/css" href="/assets/css/paid.css?ver=39" />
<table cellspacing="0" boroder="0" id="header">
  <td class="edge"><img src="/assets/img/icon/menu.png" alt="menu" class="icon" id="menu"></td>
  <td id="center"><h1 class="font_8 unread">有料クイズ</h1></td>
  <td class="edge" id="search"><img src="/assets/img/icon/magnifier.png" alt="search" class="icon"></td>
</table>

<?php
  $side = View::forge('side');
  $side->this_page = 'paid';
  echo $side;
?>

<div id="content">
<table>
<tr><td colspan="2"><input type="text" placeholder="#日本の城" maxlength="12" id="tag_name" class="txt_84"></td></tr>
<tr><td class="td_49">所持ポイント</td><td class="td_49" id="point"></td></tr>
</table>
<table id="cel">
<tr><td class="td_98_c"><a href="/htm/mypaid/">購入したクイズ</a></td></tr>
<?php foreach($pack as $k => $d){ ?>
<tr>
  <td class="td_99_c">
    <a href="/pack/?p=<?=$d['id']?>">
      <input type="text" value="<?=Security::htmlentities($d['txt'])?>" readonly class="input_txt_c">
    </a>
  </td>
</tr>
<?php } ?>
</table>
<br>
<table>
  <tr>
  <td class="move"><a href="/paid/?page=<?=$page+1?>"> << </a></td>
  <td class="move">||</td>
  <td class="move"><a href="/paid/?page=<?=$page-1?>"> >> </a></td>
  </tr>
</table>
<?= View::forge('htm/ad_load') ?>
</div>
<script src="/assets/js/basic.js?ver=39"></script>
<script src="/assets/js/check_news.js?ver=39"></script>
<script src="/assets/js/paid.js?ver=39"></script>
</body>
</html>

