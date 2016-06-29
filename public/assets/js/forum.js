$('#generate').click(function(){
  if(!u_id){
    alert('answer first');
    return;
  }
  var validate = 1;
  if(change_pic == 1){
    var mycanvas = document.getElementById('mycanvas1');
    var imgdata = mycanvas.toDataURL();
  }else{
    var imgdata = 'no';
  }
  if(imgdata == 'no' && $('#txt').val()==''){
    $('#txt').css({'border-color':'red'});
    validate=2
  }
  if(validate==2){
    return;
  }
  $('#generate').css({'display': 'none'});  
  $('#success').css({'display': ''});
  if(localStorage.myphoto){
    var myphoto = localStorage.myphoto;
  }else{
    var myphoto = '';
  }
  var param = {
    csrf : csrf
    ,txt : $('#txt').val()
    ,img : imgdata
    ,myphoto : myphoto
    ,f_id : getVal.f
  };
  $.post('/forumadd/',param,function(){},"json")
  .always(function(res){
    if(res[0]==1){
      location.href = '/forum/?f='+res[1];
    }else{
      $('#success').css({'display': 'none'});
      $('#generate').css({'display': ''});  
      alert('connection error');
    }
  });
  ga('send','event','forum','upload',localStorage.ua_u_id,1);
});

//.begin. canvas edit

function handleImage(e){
  $('#imageLoader').css({
    'display': 'none'
  });
  var reader = new FileReader();
  reader.onload = function(event){
    var img = new Image();
    img.src = event.target.result;
    var gesturableImg = new ImgTouchCanvas({
        canvas: document.getElementById('mycanvas1')
        ,path: img.src
        ,desktop: true
    });
    change_pic = 1;
  }
  reader.readAsDataURL(e.target.files[0]);     
}

var resImg = document.getElementById('mycanvas1');
var gesturableImg = new ImgTouchCanvas({
    canvas: resImg,
    path: "/assets/img/icon/camera.png"
});

var imageLoader = document.getElementById('file_load');
    imageLoader.addEventListener('change', handleImage, false);
var change_pic = 0;
//.end. canvas edit

$('#rotate').click(function(){
  var canvas = document.getElementById('mycanvas1');
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
localStorage.scale = 10;
$('[name=scale]').change(function(){
  localStorage.scale = $('[name=scale] option:selected').text();
});

var arr_nice = [];
if(localStorage.nice){
  arr_nice = JSON.parse(localStorage.nice);
}

for (var i=0; i<arr_nice.length; i++){
  for (var ii=0; ii<arr_forum.length; ii++){
    if(arr_nice[i] == arr_forum[ii]){
      is_nice = true;
      $('#f_img_'+arr_forum[ii]).attr({'src': '/assets/img/icon/thumbup_1.png'});
    }
  }
}

$('.nice').click(function(){
  var is_nice = false;
  for (var i=0; i<arr_nice.length; i++){
    if( arr_nice[i] == $(this).data('forum')){
      is_nice = true;
    }
  }
  if (!is_nice) {
    var amt_nice = $('#nice_'+$(this).data('forum') ).text();
    $('#nice_'+$(this).data('forum')).text(amt_nice*1 + 1);
    $('#f_img_'+$(this).data('forum')).attr({'src': '/assets/img/icon/thumbup_1.png'});
    $(this).attr({'src': '/assets/img/icon/thumbup_1.png'});  
    var param = {
      csrf : csrf
      ,f_id : $(this).data('forum')
    };
    $.post('/niceadd/',param,function(){},"json")
    .always(function(res){
      if(res[0]==1){
        csrf = res[1];
      }else if(res[0]==2){
        alert('connection error');
      }
    });
    arr_nice[arr_nice.length] = $(this).data('forum');
    localStorage.nice = JSON.stringify(arr_nice);
  }
});
