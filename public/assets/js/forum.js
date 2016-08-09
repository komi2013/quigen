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
  if(imgdata == 'no' && $('#txt').html()==''){
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
  if(localStorage.myname){
    var myname = localStorage.myname;
  }else{
    var myname = '';
  }
  var param = {
    csrf : csrf
    ,txt : $('#txt').html()
    ,img : imgdata
    ,myphoto : myphoto
    ,myname : myname
    ,f_id : getVal.f
  };
  $.post('/forumcommentadd/',param,function(){},"json")
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
  $('#emoji_list').css({'display': 'none'});
  $('#canvas_menu').css({'display': 'inline'});
  $('#mycanvas1').css({
    'position': 'static'
    ,'top': '0px'
    ,'left': '0px'
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
    //location.hash = 'mycanvas1';
    window.scrollTo(0,document.body.scrollHeight);
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

$('.reply').click(function(){
  $('#txt').append('RE:'+$(this).data('fc_u_name')+'　');
});

$('#emoji_show').click(function(){
  $('#emoji_list').css({'display': 'block'});
  $('#canvas_menu').css({'display': 'none'});
  $('#mycanvas1').css({'display': 'none'});
  window.scrollTo(0,document.body.scrollHeight);
});

$('.emoji').click(function(){
  $('#txt').append('<img src="'+$(this).attr('src')+'">');
});

var arr_nice = localStorage.nice ? JSON.parse(localStorage.nice) : [];
for (var i=0; i<arr_nice.length; i++){
  for (var ii=0; ii<arr_forum.length; ii++){
    if(arr_nice[i] == arr_forum[ii]){
      is_nice = true;
      $('#f_nice_img_'+arr_forum[ii]).attr({'src': '/assets/img/icon/thumbup_1.png'});
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
    var amt_nice = $('#f_nice_amt_'+$(this).data('forum') ).text();
    $('#f_nice_amt_'+$(this).data('forum')).text(amt_nice*1 + 1);
    $('#f_nice_amt_'+$(this).data('forum')).css({'display': ''});
    $('#f_nice_img_'+$(this).data('forum')).attr({'src': '/assets/img/icon/thumbup_1.png'});
    var param = {
      csrf : csrf
      ,f_id : $(this).data('forum')
      ,param : 'nice'
      ,table : 'forum'
      ,u_id : $(this).data('f_u_id')
    };
    $.post('/forumparamadd/',param,function(){},"json")
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

var arr_certify = localStorage.certify ? JSON.parse(localStorage.certify) : [];
for (var i=0; i<arr_certify.length; i++){
  for (var ii=0; ii<arr_forum.length; ii++){
    if(arr_certify[i] == arr_forum[ii]){
      is_certify = true;
      $('#f_certify_img_'+arr_forum[ii]).attr({'src': '/assets/img/icon/medal_1.png'});
    }
  }
}

var certified = localStorage.certified ? localStorage.certified : 0;
$('.certify').click(function(){
  if(certified > (hour_stamp - 20) ){
    alert('only once a day');
    return;
  }
  var is_certify = false;
  for (var i=0; i<arr_certify.length; i++){
    if( arr_certify[i] == $(this).data('forum')){
      is_certify = true;
    }
  }
  if (!is_certify) {
    var amt_certify = $('#f_certify_amt_'+$(this).data('forum') ).text();
    $('#f_certify_amt_'+$(this).data('forum')).text(amt_certify*1 + 1);
    $('#f_certify_amt_'+$(this).data('forum')).css({'display': ''});
    $('#f_certify_img_'+$(this).data('forum')).attr({'src': '/assets/img/icon/medal_1.png'});
    var param = {
      csrf : csrf
      ,f_id : $(this).data('forum')
      ,param : 'certify'
      ,table : 'forum'
      ,u_id : $(this).data('f_u_id')
    };
    $.post('/forumparamadd/',param,function(){},"json")
    .always(function(res){
      if(res[0]==1){
        csrf = res[1];
      }else if(res[0]==2){
        alert('connection error');
      }
    });
    arr_certify[arr_certify.length] = $(this).data('forum');
    localStorage.certify = JSON.stringify(arr_certify);
    certified = hour_stamp;
  }
});

//_c = comment
var arr_nice_c = localStorage.nice_c ? JSON.parse(localStorage.nice_c) : [];
for (var i=0; i<arr_nice_c.length; i++){
  for (var ii=0; ii<arr_comment.length; ii++){
    if(arr_nice_c[i] == arr_comment[ii]){
      $('#fc_nice_img_'+arr_comment[ii]).attr({'src': '/assets/img/icon/thumbup_1.png'});
    }
  }
}

$('.nice_c').click(function(){
  var is_nice_c = false;
  for (var i=0; i<arr_nice_c.length; i++){
    if( arr_nice_c[i] == $(this).data('comment')){
      is_nice_c = true;
    }
  }
  if (!is_nice_c) {
    var amt_nice_c = $('#fc_nice_amt_'+$(this).data('comment') ).text();
    $('#fc_nice_amt_'+$(this).data('comment')).text(amt_nice_c*1 + 1);
    $('#fc_nice_amt_'+$(this).data('comment')).css({'display': ''});
    $('#fc_nice_img_'+$(this).data('comment')).attr({'src': '/assets/img/icon/thumbup_1.png'});
    var param = {
      csrf : csrf
      ,f_id : $(this).data('comment')
      ,param : 'nice'
      ,table : 'forum_comment'
      ,u_id : $(this).data('fc_u_id')
    };
    $.post('/forumparamadd/',param,function(){},"json")
    .always(function(res){
      if(res[0]==1){
        csrf = res[1];
      }else if(res[0]==2){
        alert('connection error');
      }
    });
    arr_nice_c[arr_nice_c.length] = $(this).data('comment');
    localStorage.nice_c = JSON.stringify(arr_nice_c);
  }
});

var arr_certify_c = localStorage.certify_c ? JSON.parse(localStorage.certify_c) : [];
for (var i=0; i<arr_certify_c.length; i++){
  for (var ii=0; ii<arr_comment.length; ii++){
    if(arr_certify_c[i] == arr_comment[ii]){
      $('#fc_certify_img_'+arr_comment[ii]).attr({'src': '/assets/img/icon/medal_1.png'});
    }
  }
}

$('.certify_c').click(function(){
  if(certified > (hour_stamp - 20) ){
    alert('only once a day');
    return;
  }
  var is_certify_c = false;
  for (var i=0; i<arr_certify_c.length; i++){
    if( arr_certify_c[i] == $(this).data('comment')){
      is_certify_c = true;
    }
  }
  if (!is_certify_c) {
    var amt_certify_c = $('#fc_certify_amt_'+$(this).data('comment') ).text();
    $('#fc_certify_amt_'+$(this).data('comment')).text(amt_certify_c*1 + 1);
    $('#fc_certify_amt_'+$(this).data('comment')).css({'display': ''});
    $('#fc_certify_img_'+$(this).data('comment')).attr({'src': '/assets/img/icon/medal_1.png'});
    var param = {
      csrf : csrf
      ,f_id : $(this).data('comment')
      ,param : 'certify'
      ,table : 'forum_comment'
      ,u_id : $(this).data('fc_u_id')
    };
    $.post('/forumparamadd/',param,function(){},"json")
    .always(function(res){
      if(res[0]==1){
        csrf = res[1];
      }else if(res[0]==2){
        alert('connection error');
      }
    });
    arr_certify_c[arr_certify_c.length] = $(this).data('comment');
    localStorage.certify_c = JSON.stringify(arr_certify_c);
    certified = hour_stamp;
  }
});
