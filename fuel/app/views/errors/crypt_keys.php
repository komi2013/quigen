<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8" />
    <title>crypt keys error</title>
    <link rel="shortcut icon" href="/assets/img/icon/quiz_generator.png">
    <script src="/third/jquery-2.1.1.min.js"></script>
    <script src="/third/jquery.cookie.js"></script>
    <link rel="stylesheet" type="text/css" href="/assets/css/basic.css?ver=59" />
    <meta name="viewport" content="width=device-width, user-scalable=no" >
    <script>var ua = '<?=Config::get("my.ua")?>';</script>
    <script src="/assets/js/analytics.js?ver=59"></script>
  </head>
<body>
<table cellspacing="0" boroder="0" id="header">
  <td class="edge"><img src="/assets/img/icon/menu.png" alt="menu" class="icon" id="menu"></td>
  <td id="center">crypt keys error</td>
  <td class="edge" id="right"></td>
</table>
<?php
  $side = View::forge('side');
  $side->this_page = '';
  echo $side;
?>
<div id="content">
  <h1>crypt keys error</h1>
</div>
<?php Model_Log::warn('crypt keys error');?>
<script src="/assets/js/basic.js?ver=59"></script>
<script>
  ga('send', 'pageview', location.pathname + location.search + location.hash +':crypt_keys_error');
</script>

</body>
</html>
