<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8" />
    <title>クエスト</title>
    <link rel="shortcut icon" href="/assets/img/icon/quiz_generator.png" />
    <meta name="robots" content="noindex">
    <script src="/third/jquery-2.1.1.min.js"></script>
    <script src="/third/jquery.cookie.js"></script>
    <script>var ua = '<?=Config::get("my.ua")?>';</script>
    <script src="/assets/js/analytics.js?ver=41"></script>
    <link rel="stylesheet" type="text/css" href="/assets/css/basic.css?ver=41" />
    <link rel="stylesheet" href="/assets/css/pc.css?ver=41" media="only screen and (min-width : 711px)">
    <link rel="stylesheet" href="/assets/css/sp.css?ver=41" media="only screen and (max-width : 710px)">
    <meta name="viewport" content="width=device-width, user-scalable=no" >
  </head>
<body>
<style>
.quest_do{
  background-color: #CBFFD3;
}
</style>
<table cellspacing="0" boroder="0" id="header">
  <td class="edge"><img src="/assets/img/icon/menu.png" alt="menu" class="icon" id="menu"></td>
  <td id="center"><h1 class="font_8 unread">クエスト</h1></td>
  <td class="edge"></td>
</table>
<?php
  $side = View::forge('side');
  $side->this_page = '';
  echo $side;
?>

<div id="content">

<table>
  <tr>
    <td class="td_68"><a id="pre_quiz" href="/top/">クイズに戻る</a></td>
    <td class="td_15"><img src="/assets/img/icon/ticket.png" alt="ticket"></td>
    <td class="td_15" id="ticket" style="color:red;">0</td>
  </tr>
</table>

<table>
  <tr><td class="td_99 quest_do" id="light_2">○下記の時間以降に回答できます</td></tr>  
</table>

<table>
  <tr><td class="td_99" id="open_time" style="text-align:center;"></td></tr>
</table>

<table>
  <tr>
    <td class="td_15"><img src="/assets/img/icon/hourglass.png" alt="wait"></td>
    <td class="td_84" id="left_time">0</td>
  </tr>
</table>
<br>
<table>
  <tr><td class="td_99 quest_do" id="light_1">○もしくは下記のページにいけばまたクイズに回答できます</td></tr>
</table>

<table>
  <tr><td class="quest_1 td_99_c">クイズに答える</td>                                   <td class="td_15_c"><img src="/assets/img/icon/star_1.png"></td></tr>
  <tr><td class="quest_1 td_99_c"><a href="/top/">他のクイズを確認</a></td>             <td class="td_15_c" id="img_quest_0"><img src="/assets/img/icon/star_0.png"></td></tr>
  <tr><td class="quest_1 td_99_c"><a href="/myanswer/">マイアンサー(復習)を確認</a></td><td class="td_15_c" id="img_quest_1"><img src="/assets/img/icon/star_0.png"></td></tr>
  <tr><td class="quest_1 td_99_c"><a href="/myprofile/">マイプロファイルを確認</a></td> <td class="td_15_c" id="img_quest_2"><img src="/assets/img/icon/star_0.png"></td></tr>

  <tr><td class="quest_2 td_99_c"><a href="/rank/">ランクを確認</a></td>         <td class="quest_2 td_15_c" id="img_quest_3"><img src="/assets/img/icon/star_0.png"></td></tr>
  <tr><td class="quest_2 td_99_c"><a href="/htm/rule/">使い方と規約を確認</a></td>    <td class="quest_2 td_15_c" id="img_quest_4"><img src="/assets/img/icon/star_0.png"></td></tr>
  <tr><td class="quest_2 td_99_c">クイズをシェア</td>                                   <td class="quest_2 td_15_c" id="img_quest_5"><img src="/assets/img/icon/star_0.png"></td></tr>
  <tr><td class="quest_2 td_99_c">クイズにコメント</td>                                 <td class="quest_2 td_15_c" id="img_quest_6"><img src="/assets/img/icon/star_0.png"></td></tr>
  <tr><td class="quest_2 td_99_c">クイズを作成</td>                                     <td class="quest_2 td_15_c" id="img_quest_7"><img src="/assets/img/icon/star_0.png"></td></tr>
</table>
<br>
<table>
  <tr>
    <td class="td_84 quest_do" id="light_3">○もしくはポイントでチケットをGET</td>
    <td class="td_15 quest_do">
      <img src="/assets/img/icon/upload_0.png" alt="generate" class="icon" id="generate">
      <img src="/assets/img/icon/success.png" alt="success" class="icon" id="success" style="display:none;">
    </td>
  </tr>  
</table>

<table>
<tr><td class="td_49">所持ポイント</td><td class="td_49" id="point">0 pt</td></tr>
</table>

<table>
  <tr>
    <td class="td_15"><input type="radio" name="pay_point" value="100"></td>
    <td class="td_42">100ポイント</td>
    <td class="td_42">20チケット</td>
  </tr>
  <tr>
    <td class="td_15"><input type="radio" name="pay_point" value="800"></td>
    <td class="td_42">800ポイント</td>
    <td class="td_42">170チケット</td>
  </tr>
  <tr>
    <td class="td_15"><input type="radio" name="pay_point" value="1400"></td>
    <td class="td_42">1400ポイント</td>
    <td class="td_42">300チケット</td>
  </tr>
</table>

<table>
  <tr>
  <td class="td_99_c"><a href="/htm/exchange_point/?send=1">ポイントを購入</a></td>
  </tr>
</table>

<?= View::forge('htm/ad_load') ?>
</div>
<?= View::forge('htm/ad_load_right') ?>

<script>
  var u_id = '<?=@$u_id?>';
  var csrf = '<?=Model_Csrf::setcsrf()?>';
</script>
<script src="/assets/js/basic.js?ver=41"></script>
<script src="/assets/js/quest.js?ver=41"></script>
</body>
</html>