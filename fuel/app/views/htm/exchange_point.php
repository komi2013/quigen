<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8" />
    <title>exchange point</title>
    <link rel="shortcut icon" href="/assets/img/icon/quiz_generator.png" />
    <meta name="robots" content="noindex">
    <script src="/third/jquery-2.1.1.min.js"></script>
    <script src="/third/jquery.cookie.js"></script>
    <script>var ua = '<?=Config::get("my.ua")?>';</script>
    <script src="/assets/js/analytics.js?ver=88"></script>
    <link rel="stylesheet" type="text/css" href="/assets/css/basic.css?ver=88" />
    <link rel="stylesheet" href="/assets/css/pc.css?ver=88" media="only screen and (min-width : 711px)">
    <link rel="stylesheet" href="/assets/css/sp.css?ver=88" media="only screen and (max-width : 710px)">
    <meta name="viewport" content="width=device-width, user-scalable=no" >
  </head>
<body>

<?php
  $side = View::forge('side');
  $side->this_page = '';
  echo $side;
?>

<div id="content">

<?php if( isset($_GET['send']) ){?>
<div id="after_post">
<table>
  <tr> <td class="td_99">
choose which point you want
I will contact with you later
then you would put the money my bacnk account
as soon as I confirm, I will give you point
  </td> </tr>
</table>

<table>
  <tr>
    <td class="td_15"><input type="radio" name="buy_point" value="100"></td>
    <td class="td_42">100 yen</td>
    <td class="td_42">200 pt</td>
  </tr>
  <tr>
    <td class="td_15"><input type="radio" name="buy_point" value="800"></td>
    <td class="td_42">800 yen</td>
    <td class="td_42">1700 pt</td>
  </tr>
  <tr>
    <td class="td_15"><input type="radio" name="buy_point" value="1400"></td>
    <td class="td_42">1400 yen</td>
    <td class="td_42">3000 pt</td>
  </tr>
</table>

<table>
  <tr><td><input type="text" placeholder="bank account" id="sender" class="txt_99"></td></tr>
</table>
</div>
<?php }else{ ?>
<table>
  <tr><td class="explain">point</td><td id="point" class="numeric">0</td><td class="currecncy">pt</td></tr>
  <tr><td class="explain">exchange point</td><td id="exchange" class="numeric" style="text-align:left;">
    <select id="unit">
      <option>0</option>
      <option>2</option>
      <option>4</option>
      <option>6</option>
      <option>8</option>
      <option>10</option>
    </select>
      0,000</td><td class="currecncy">pt</td>
  </tr>
  <tr><td class="explain">fee</td><td id="fee" class="numeric">1000</td><td class="currecncy">yen</td></tr>
  <tr><td class="explain">point</td><td id="money" class="numeric"></td><td class="currecncy">yen</td></tr>
</table>
<table>
  <tr><td id="info"><textarea placeholder="bank info" id="bank_info"></textarea></td></tr>
  <tr><td id="txt"><input type="email" placeholder="email" value="" id="email"></td></tr>
</table>
<?php } ?>
<div style="width:100%;text-align: right;">
<?php if( isset($_GET['send']) ){?>
    <img src="/assets/img/icon/upload_0.png" alt="generate" class="icon" id="generate_send">
<?php }else{ ?>
    <img src="/assets/img/icon/upload_0.png" alt="generate" class="icon" id="generate">
<?php } ?>
    <img src="/assets/img/icon/success.png" alt="success" class="icon" id="success" style="display:none;">
</div>
<div id="ad"><iframe src="/htm/ad_blank/" width="320" height="50" frameborder="0" scrolling="no"></iframe></div>
</div>
<script>
  var u_id = '<?=$u_id?>';
  var send = '<?= isset($_GET['send']) ? $_GET['send'] : 0 ; ?>';
  var csrf = '<?=Model_Csrf::setcsrf()?>';
</script>
<script src="/assets/js/check_news.js?ver=88"></script>
<script src="/assets/js/basic.js?ver=88"></script>
<script src="/assets/js/exchange_point.js?ver=88"></script>
<script>
  $(function(){ ga('send', 'pageview'); });
</script>
</body>
</html>
