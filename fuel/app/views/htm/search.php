<?php
if ( isset($_GET['tag']) ) {
  $tag = $_GET['tag'];
}else{
  $tag = '';
}
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8" />
    <title><?=$tag?></title>
    <meta name="robots" content="noindex">
    <link rel="shortcut icon" href="/assets/img/icon/quiz_generator.png">
    <script src="/third/jquery-2.1.1.min.js"></script>
    <script src="/third/jquery.cookie.js"></script>
    <meta property="og:title" content="<?=$tag?>" />
    <meta property="og:url" content="<?='http://'.Config::get("my.domain").'/htm/search/?tag='.urlencode($tag)?>" />
    <meta property="og:description" content="<?=$tag?>のクイズ一覧です。他のタグでも検索できます。" />
    <script>var ua = '<?=Config::get("my.ua")?>';</script>
    <script src="/assets/js/analytics.js?ver=39"></script>
    <link rel="stylesheet" type="text/css" href="/assets/css/basic.css?ver=39" />
    <link rel="stylesheet" href="/assets/css/pc.css?ver=39" media="only screen and (min-width : 711px)">
    <link rel="stylesheet" href="/assets/css/sp.css?ver=39" media="only screen and (max-width : 710px)">
    <meta name="viewport" content="width=device-width, user-scalable=no" >
  </head>
<body>

<table cellspacing="0" boroder="0" id="header">
  <td class="edge"><img src="/assets/img/icon/menu.png" alt="menu" class="icon" id="menu"></td>
  <td id="center"><h1 class="font_8 unread"><?=$tag?></h1></td>
  <td class="edge"><img src="/assets/img/icon/magnifier.png" alt="search" class="icon" id="search"></td>
</table>
<?php
  $side = View::forge('side');
  $side->this_page = '';
  echo $side;
?>
<div id="content">

<table>
  <tr><td style="text-align: center;">
    <input type="text" list="tag_list" value="<?=$tag?>" maxlength="50" id="tag_name" class="txt_84">
    <datalist id="tag_list"></datalist>
  </td></tr>
</table>
<?= View::forge('htm/ad_load') ?>
<table id="cel"></table>
</div>
<?= View::forge('htm/ad_load_right') ?>

<script> var tag = '<?=$tag?>'; </script>
<script src="/assets/js/basic.js?ver=39"></script>
<script src="/assets/js/check_news.js?ver=39"></script>
<script src="/assets/js/search.js?ver=39"></script>
</body>
</html>