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
    <script src="/assets/js/analytics.js?ver=87"></script>
    <link rel="stylesheet" type="text/css" href="/assets/css/basic.css?ver=87" />
    <link rel="stylesheet" href="/assets/css/pc.css?ver=87" media="only screen and (min-width : 711px)">
    <link rel="stylesheet" href="/assets/css/sp.css?ver=87" media="only screen and (max-width : 710px)">
    <meta name="viewport" content="width=device-width, user-scalable=no" >
  </head>
<body>
<script src="/third/img-touch-canvas_1.js?ver=87"></script>

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

<div id="ad"><iframe src="/htm/ad_blank/" width="320" height="50" frameborder="0" scrolling="no"></iframe></div>
<table>
  <tr><td class="td_99_c"><a href="https://www.youtube.com/watch?v=ZQlq1a-jPHw" target="_blank">how to use(video)</a></td></tr>
  <tr><td class="td_99_c"><a href="http://quizgenerator-help.hatenadiary.jp/archive/2015" target="_blank">how to use(blog)</a></td></tr>
  <tr><td class="td_99_c"><a href="/htm/rule/">rule</a></td></tr>
</table>

</div>

<div id="ad_right"></div>

<script>
  var arr_forum = JSON.parse( '<?= json_encode($arr_forum) ?>' );
  var u_id = '<?=$u_id?>';
  var csrf = '<?=Model_Csrf::setcsrf()?>';
</script>
<script src="/assets/js/check_news.js?ver=87"></script>
<script src="/assets/js/basic.js?ver=87"></script>
<script src="/assets/js/forum_list.js?ver=87"></script>
<script>
  $(function(){ ga('send', 'pageview'); });
</script>
</body>
</html>
