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
    <script>var ua = '<?=Config::get("my.ua")?>';</script>
    <script src="/assets/js/analytics.js?ver=60"></script>
    <link rel="stylesheet" type="text/css" href="/assets/css/basic.css?ver=60" />
    <link rel="stylesheet" href="/assets/css/pc.css?ver=60" media="only screen and (min-width : 711px)">
    <link rel="stylesheet" href="/assets/css/sp.css?ver=60" media="only screen and (max-width : 710px)">
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
#imageLoader{
  opacity: 0;
  position: absolute;
  height: 300px;
  width: 300px;
  z-index: 5;
}
</style>
<script>var ua = '<?=Config::get("my.ua")?>';</script>
<script src="/assets/js/analytics.js"></script>

<table cellspacing="0" id="header">
  <td class="edge"></td>
  <td id="center">写真アップロード</td>
  <td class="edge">
    <img src="/assets/img/icon/upload_0.png" alt="generate" class="icon" id="generate">
    <img src="/assets/img/icon/circle_big.png" alt="success" class="icon" id="success" style="display:none;">
  </td>
</table>

<table cellspacing="0">
  <tr>
  <td id="rotate" style="width:50px;"><img src="/assets/img/icon/rotate.png" class="icon" alt="rotate"></td>
  <td id="minus" class="sp_disp_none" style="width:50px;"><img src="/assets/img/icon/minus.png" class="icon" alt="minus"></td>
  <td class="sp_disp_none" style="width:50px;">
    <select name='scale' style="font-size:20px;">
        <option>1</option>
        <option>5</option>
        <option>10</option>
        <option>20</option>
        <option>40</option>
    </select>
  </td>
  <td id="plus" class="sp_disp_none" style="width:50px;"><img src="/assets/img/icon/plus.png" class="icon" alt="plus"></td>
  </tr>
</table>

<div id="canvas_div_img" style="text-align:center;">
<input type="file" id="imageLoader" name="imageLoader">
<canvas id="mycanvas" height="300" width="300"></canvas>
</div>

<script>
var resImg = document.getElementById('mycanvas');
var gesturableImg = new ImgTouchCanvas({
    canvas: resImg,
    path: "/assets/img/icon/camera.png"
});

var imageLoader = document.getElementById('imageLoader');
    imageLoader.addEventListener('change', handleImage, false);
var change_pic = 0;
function handleImage(e){
    $('#imageLoader').css({
      'display': 'none'
    });
    var reader = new FileReader();
    reader.onload = function(event){
      var img = new Image();
      img.src = event.target.result;
      var gesturableImg = new ImgTouchCanvas({
          canvas: document.getElementById('mycanvas')
          ,path: img.src
          ,desktop: true
      });
      change_pic = 1;
    }
    reader.readAsDataURL(e.target.files[0]);     
}

$('#generate').click(function(){
  var mycanvas = document.getElementById('mycanvas');
  var imgdata = mycanvas.toDataURL();
  $('#generate').css({'display': 'none'});  
  $('#success').css({'display': ''});
  localStorage.setItem('img',imgdata);
  window.opener.document.getElementById("photo").src = imgdata;
  window.opener.winCloseB();
  $('#canvas_div_img').empty().append('閉じてください');
});

$('#rotate').click(function(){
  var canvas = document.getElementById('mycanvas');
  var ctx = canvas.getContext('2d');
  var image = new Image();
  image.src = canvas.toDataURL();
  var rad = Math.atan2(1, 0);
  ctx.save();
  var image_width  = 300;
  var image_height = 300;
  ctx.translate(150, 150);
  ctx.rotate(rad);
  ctx.translate(-150, -150);
  ctx.drawImage(image,0,0);
  if(change_pic == 1){
    gesturableImg.rotate = gesturableImg.rotate + 1;
  }
});

</script>
<script>
  ga('send', 'pageview');
</script>
</body>
</html>