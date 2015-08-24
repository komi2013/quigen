<!DOCTYPE html>
<html>
    <head>
    <meta charset="UTF-8" />
    <title>詳細設定</title>
    <link rel="shortcut icon" href="/assets/img/icon/quiz_generator.png">
    <script src="/third/jquery-2.1.1.min.js"></script>
    <script src="/third/jquery.cookie.js"></script>
    <link rel="stylesheet" type="text/css" href="/assets/css/basic.css?ver=31" />
    <link rel="stylesheet" href="/assets/css/pc.css?ver=31" media="only screen and (min-width : 711px)">
    <link rel="stylesheet" href="/assets/css/sp.css?ver=31" media="only screen and (max-width : 710px)">
    <meta name="viewport" content="width=device-width, user-scalable=no" >
    </head>
<body>
<style>
.img_profile{
  max-height: 150px;
  max-width: 150px;
}
</style>
<script>var ua = '<?=Config::get("my.ua")?>';</script>
<script src="/assets/js/analytics.js"></script>

<table cellspacing="0" id="header">
  <td class="edge"><img src="/assets/img/icon/rotate.png" alt="rotate" id="rotate" class="icon"></td>
  <td id="center">詳細設定</td>
  <td class="edge">
    <img src="/assets/img/icon/upload_0.png" alt="generate" class="icon" id="generate">
    <img src="/assets/img/icon/circle_big.png" alt="success" class="icon" id="success" style="display:none;">
  </td>
</table>

<table cellspacing="0">
  <tr><td class="td_98_c">画像アップロード設定</td></tr>
  <tr><td class="td_99"><input type="radio" name="img_from" value="device" id="img_from_device"><label for="img_from_device">デバイス</label></td></tr>
  <tr><td class="td_99"><input type="radio" name="img_from" value="url" id="img_from_url"><label for="img_from_url">URL</label></td></tr>
</table>


<div style="display:none;">
<table cellspacing="0"><tr>
  <td class="td_98_c">アンサー設定</td>
</tr></table>

<input type="radio" name="answer" value="txt" checked>テキスト<br><br>

&nbsp;&nbsp;画像選択<br>
&nbsp;&nbsp;<input type="radio" name="answer" value="device">デバイス<br>
&nbsp;&nbsp;<input type="radio" name="answer" value="url">URL

<table cellspacing="0"><tr>
  <td class="td_98_c">質問設定</td>
</tr></table>
<input type="radio" name="q_from" value="txt" checked>テキスト<br>
<input type="radio" name="q_from" value="url">URL&nbsp;*youtube,instagram,vine,googleドメインのみ対応
</div>
<script>
if(localStorage.img_from && localStorage.img_from == 'url'){
  $("input[name='img_from']").val(['url']); 
}else{
  $("input[name='img_from']").val(['device']); 
}
$("#generate").click( function(){
  $('#generate').css({'display': 'none'});  
  $('#success').css({'display': ''});
  var img_from = $("input[name='img_from']:checked").val();
  var answer = $("input[name='answer']:checked").val();
  var q_from = $("input[name='q_from']:checked").val();
  localStorage.img_from = img_from;
  localStorage.answer_from = answer;
  localStorage.q_from = q_from;
  location.href = "/generate/";
});

</script>
</body>
</html>