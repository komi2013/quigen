<!DOCTYPE html>
<html>
    <head>
    <meta charset="UTF-8" />
    <title>写真アップロード</title>
    <link rel="shortcut icon" href="/assets/img/icon/quiz_generator.png">
    <script src="/third/jquery-2.1.1.min.js"></script>
    <script src="/third/jquery.cookie.js"></script>
    <link rel="stylesheet" type="text/css" href="/assets/css/basic.css" />
    <script src="/third/img-touch-canvas_1.js"></script>
    <link rel="stylesheet" type="text/css" href="/assets/css/basic.css?ver=31" />
    <link rel="stylesheet" href="/assets/css/pc.css?ver=31" media="only screen and (min-width : 711px)">
    <link rel="stylesheet" href="/assets/css/sp.css?ver=31" media="only screen and (max-width : 710px)">
    <meta name="viewport" content="width=device-width, user-scalable=no" >
    <meta name="viewport" content="width=device-width, user-scalable=no" >
    </head>
<body>
<style>
.img_profile{
  max-height: 150px;
  max-width: 150px;
}
body{
  text-align: center;
}
</style>
<script>var ua = '<?=Config::get("my.ua")?>';</script>
<script src="/assets/js/analytics.js"></script>

<table cellspacing="0" id="header">
  <td class="edge"><img src="/assets/img/icon/rotate.png" alt="rotate" id="rotate" class="icon"></td>
  <td id="center">写真アップロード</td>
  <td class="edge">
    <img src="/assets/img/icon/upload_0.png" alt="generate" class="icon" id="generate">
    <img src="/assets/img/icon/circle_big.png" alt="success" class="icon" id="success" style="display:none;">
  </td>
</table>

<table id="eto_pet">
  <tr><td><img src="/assets/img/eto/07_horse.png" alt="horse" class="img_profile"></td><td><img src="/assets/img/eto/08_sheep.png" alt="sheep" class="img_profile"></td></tr>
  <tr><td><img src="/assets/img/eto/09_monkey.png" alt="monkey" class="img_profile"></td><td><img src="/assets/img/eto/10_hen.png" alt="hen" class="img_profile"></td></tr>
  <tr><td><img src="/assets/img/eto/11_dog.png" alt="dog" class="img_profile"></td><td><img src="/assets/img/eto/12_pig.png" alt="pig" class="img_profile"></td></tr>
</table>

<div id="zeni"></div>
<canvas id="mycanvas" height="300" width="300"></canvas>

<script>

  var rand1 = Math.floor(Math.random()*255);
  var rand2 = Math.floor(Math.random()*255);
  var rand3 = Math.floor(Math.random()*255);
$('.img_profile').click(function(){
  var canvas = document.getElementById('mycanvas');
  var ctx = canvas.getContext('2d');
  var img = new Image();
  img.src = $(this).attr('src');
  $('#eto_pet').css({'display': 'none'});
  setTimeout(function(){
    var rand1 = Math.floor(Math.random()*255);
    var rand2 = Math.floor(Math.random()*255);
    var rand3 = Math.floor(Math.random()*255);
  //  ctx.save();
    ctx.fillStyle = 'rgba('+rand1+','+rand2+','+rand3+',0.4)';
    ctx.fillRect(0, 0, 300, 300);
    ctx.drawImage(img, 0, 0);
  },500);

});
$('#generate').click(function(){
  var mycanvas = document.getElementById('mycanvas');
  var imgdata = mycanvas.toDataURL();
  $('#generate').css({'display': 'none'});  
  $('#success').css({'display': ''});
  localStorage.setItem('img',imgdata);
  window.opener.document.getElementById("photo").src = imgdata;
  window.opener.winCloseB();
  $('#img_place').empty().append('閉じてください');
});

</script>
</body>
</html>