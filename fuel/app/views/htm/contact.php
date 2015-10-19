<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8" />
    <title>お問い合わせ</title>
    <link rel="shortcut icon" href="/assets/img/icon/quiz_generator.png" />
    <meta name="robots" content="noindex">
    <script src="/third/jquery-2.1.1.min.js"></script>
    <script src="/third/jquery.cookie.js"></script>
    <script>var ua = '<?=Config::get("my.ua")?>';</script>
    <script src="/assets/js/analytics.js?ver=38"></script>
    <link rel="stylesheet" type="text/css" href="/assets/css/basic.css?ver=38" />
    <link rel="stylesheet" href="/assets/css/pc.css?ver=38" media="only screen and (min-width : 711px)">
    <link rel="stylesheet" href="/assets/css/sp.css?ver=38" media="only screen and (max-width : 710px)">
    <meta name="viewport" content="width=device-width, user-scalable=no" >
  </head>
<body>

<table cellspacing="0" boroder="0" id="header">
  <td class="edge"><img src="/assets/img/icon/menu.png" alt="menu" class="icon" id="menu"></td>
  <td id="center"><h1 class="font_8 unread">お問い合わせ</h1></td>
  <td class="edge">
    <img src="/assets/img/icon/upload_0.png" alt="generate" class="icon" id="generate">
    <img src="/assets/img/icon/success.png" alt="success" class="icon" id="success" style="display:none;">
  </td>
</table>
<?php
  $side = View::forge('side');
  $side->this_page = 'contact';
  echo $side;
?>
<div id="content">
<table><tr><td style="text-align:center;">
<textarea placeholder="連絡内容" maxlength="140" id="contact" class="txt_long"></textarea>
</td></tr></table>
   
<?= View::forge('htm/ad_load') ?>

</div>
<?= View::forge('htm/ad_load_right') ?>

<script>
  var u_id = '<?=$u_id?>';
</script>
<script src="/assets/js/check_news.js?ver=38"></script>
<script src="/assets/js/basic.js?ver=38"></script>
<script src="/assets/js/contact.js?ver=38"></script>

</body>
</html>
