<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8" />
    <title>パックNo.<?=$_GET['p']?>を購入しますか？</title>
    <meta name="description" content="このクイズを答えたい場合、まずはポイントを購入してもらいそのポイントでクイズを購入してください">
    <link rel="shortcut icon" href="/assets/img/icon/quiz_generator.png">
    <link rel="canonical" href="<?='http://'.Config::get("my.domain").'/pack/?p='.$_GET['p']?>" />
    <script src="/third/jquery-2.1.1.min.js"></script>
    <script src="/third/jquery.cookie.js"></script>
    <meta property="og:title" content="パックNo.<?=$_GET['p']?>を購入しますか？" />
    <meta property="og:url" content="<?='http://'.Config::get("my.domain").'/pack/?p='.$_GET['p']?>" />
    <meta property="og:description" content="このクイズを答えたい場合、まずはポイントを購入してもらいそのポイントでクイズを購入してください" />
    <script>var ua = '<?=Config::get("my.ua")?>';</script>
    <script src="/assets/js/analytics.js?ver=82"></script>
    <link rel="stylesheet" type="text/css" href="/assets/css/basic.css?ver=82" />
    <link rel="stylesheet" href="/assets/css/pc.css?ver=82" media="only screen and (min-width : 711px)">
    <link rel="stylesheet" href="/assets/css/sp.css?ver=82" media="only screen and (max-width : 710px)">
    <meta name="viewport" content="width=device-width, user-scalable=no" >
  </head>
<body>

<table cellspacing="0" boroder="0" id="header">
  <td class="edge"><img src="/assets/img/icon/menu.png" alt="menu" class="icon" id="menu"></td>
  <td id="center"><h1 class="font_8 unread">パックNo.<?=$_GET['p']?></h1></td>
  <td class="edge"></td>
</table>
<?php
  $side = View::forge('side');
  $side->this_page = '';
  echo $side;
?>

<div id="content">
<table>
<tr><td class="td_49">所持ポイント</td><td class="td_49" id="point"></td></tr>
</table>

<table id="cel">
<tr>
  <td class="td_15_c">
    <a href="/quiz/?q=<?=$sample_q[0]['id']?>">
      <img src="<?=$sample_q[0]['img']?:'/assets/img/icon/no_img.png'?>" alt="quiz" class="icon">
    </a>
  </td>
  <td class="td_84_c">
    <a href="/quiz/?q=<?=$sample_q[0]['id']?>">
      <input type="text" value="<?=Str::truncate(Security::htmlentities($sample_q[0]['txt']), 30)?>" readonly class="input_txt_c">
    </a>
  </td>
</tr>
</table>
<br>
<table>
  <tr>
  <td id="buy_point" class="td_txt" data-pack="<?=$_GET['p']?>"><a href="#">このクイズを購入<br>20 クイズ 200pt</a></td>
  </tr>
</table>
<br>

<form action='/paypalcheckout/' METHOD='POST'>

<table>
  <tr>
  <td class="td_49">ポイントを購入</td>
  <td class="td_49"><input type='image' name='paypal_submit' id='paypal_submit' src='https://www.paypal.com/en_US/i/btn/btn_dg_pay_w_paypal.gif'/></td>
  </tr>
</table>

<input type="hidden" name="yen" value="">
<input type="hidden" name="p" value="<?=$_GET['p']?>">

<table>
  <tr>
    <td class="td_15"><input type="radio" name="buy_point" value="100"></td>
    <td class="td_41">100 円</td>
    <td class="td_41">200 pt</td>
  </tr>
  <tr>
    <td class="td_15"><input type="radio" name="buy_point" value="800"></td>
    <td class="td_41">800 円</td>
    <td class="td_41">1700 pt</td>
  </tr>
  <tr>
    <td class="td_15"><input type="radio" name="buy_point" value="1400"></td>
    <td class="td_41">1400 円</td>
    <td class="td_41">3000 pt</td>
  </tr>

</table>
</form>
</div>
  <script>
    var csrf = '<?=Model_Csrf::setcsrf()?>';
  </script>
<script src="/assets/js/basic.js?ver=82"></script>
<script src="/assets/js/check_news.js?ver=82"></script>
<script src='https://www.paypalobjects.com/js/external/dg.js'></script>
<script src="/assets/js/request_point.js?ver=82"></script>
<script>
  $(function(){ ga('send','pageview','/request_point/'); });
</script>
</body>
</html>

