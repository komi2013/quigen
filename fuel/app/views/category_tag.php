<?php
  $meta_description = $_GET['tag'].'一覧';
  foreach($question as $k => $d){
    $meta_description .= ','.Str::truncate(Security::htmlentities($d['txt']), 30);
  }
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8" />
    <title><?=$_GET['tag']?></title>
    <meta name="description" content="<?=$meta_description?>">
    <link rel="shortcut icon" href="/assets/img/icon/quiz_generator.png" />
    <link rel="canonical" href="<?='http://'.Config::get("my.domain").'/htm/search/?tag='.urlencode($_GET['tag'])?>" />
    <script src="/third/jquery-2.1.1.min.js"></script>
    <script src="/third/jquery.cookie.js"></script>
    <script>var ua = '<?=Config::get("my.ua")?>';</script>
    <script src="/assets/js/analytics.js?ver=33"></script>
    <link rel="stylesheet" type="text/css" href="/assets/css/basic.css?ver=33" />
    <link rel="stylesheet" href="/assets/css/pc.css?ver=33" media="only screen and (min-width : 711px)">
    <link rel="stylesheet" href="/assets/css/sp.css?ver=33" media="only screen and (max-width : 710px)">
    <meta name="viewport" content="width=device-width, user-scalable=no" >
  </head>
<body>
<table cellspacing="0" boroder="0" id="header">
  <td class="edge"><img src="/assets/img/icon/menu.png" alt="menu" class="icon" id="menu"></td>
  <td id="center"><h1 class="font_8 unread"><?=$_GET['tag']?></h1></td>
  <td class="edge"></td>
</table>
<?php
  $side = View::forge('side');
  $side->this_page = '';
  echo $side;
?>
<div id="content">

<table id="cel">
<?php $i = 0; foreach($question as $k => $d){ ?>
<tr>
  <?php if($d['img']){ ?>
  <td class="td_15_c" >
    <a href="/quiz/?crypt_q=<?=$d['q_data']?>">
      <img src="<?=$d['img']?>" alt="quiz" class="icon">
    </a>
  </td>
  <td class="td_84_ct">
    <a href="/quiz/?crypt_q=<?=$d['q_data']?>">
      <input type="text" value="<?=Str::truncate(Security::htmlentities($d['txt']), 30)?>" readonly class="input_txt_c">
    </a>
  </td>
  <?php }else{ ?>
  <td colspan="2" class="td_99_c" >
    <a href="/quiz/?crypt_q=<?=$d['q_data']?>">
      <input type="text" value="<?=Str::truncate(Security::htmlentities($d['txt']), 30)?>" readonly class="input_txt_c">
    </a>
  </td>
  <?php } ?>
</tr>
<?php ++$i;} ?>
</table>

<?= View::forge('ad_load') ?>
</div>

<script src="/assets/js/check_news.js?ver=33"></script>
<script src="/assets/js/basic.js?ver=33"></script>

</body>
</html>
