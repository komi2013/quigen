var intermittent = true;
$('#generate').click(function(){
  intermittent = false;
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
  if(imgdata == 'no' && $('#txt').html().length < 30){
    alert('you must input more');
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
    ,txt : $('#txt').text()
    ,img : imgdata
    ,myphoto : myphoto
    ,myname : myname
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
    intermittent = true;
  });
  ga('send','event','forum','upload',localStorage.ua_u_id,1);
});

$('div[contenteditable]').keydown(function(e) {
  if (e.keyCode === 13) {
    document.execCommand('insertHTML', false, '<br><br>');
    return false;
  }
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
    $('#file_load').css({'display': 'none'});
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

$('#camera').click(function(){
  if(change_pic > 0){
    $('#emoji_list').css({'display': 'none'});
    $('#canvas_menu').css({'display': 'inline'});
    $('#mycanvas1').css({
      'position': 'static'
      ,'top': '0px'
      ,'left': '0px'
    });
  }
});
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

if(localStorage.quest){
  var quest = JSON.parse(localStorage.quest);
  if(quest[3] != 1){
    quest[3] = 1;
    localStorage.quest = JSON.stringify(quest);
    setTimeout(function(){
      highlighting('#page_news',0,false);
    },3000);
    var ticket = JSON.parse(localStorage.ticket);
    ticket[0] = ticket[0] + 12;
    localStorage.ticket = JSON.stringify(ticket);
    notify[2] = 'yet';
    notify[3] = 1;
    notify[4] = notify[4]+1;
    if(localStorage.news){
      var news = JSON.parse(localStorage.news);
    }else{
      var news = [];
    }
    news.unshift('<a href="/htm/quest/">'+checked_chat+'<img src="/assets/img/icon/star_1.png"></a>');
    localStorage.news = JSON.stringify(news);
    localStorage.notify = JSON.stringify(notify);
  }
}

$('#emoji_show').click(function(){
  $('#emoji_list').css({'display': 'block'});
  $('#canvas_menu').css({'display': 'none'});
  $('#mycanvas1').css({
    'position': 'absolute'
    ,'top': '-10000px'
    ,'left': '-150px'
  });
});

$('.emoji').click(function(){
  $('#txt').append('<img src="'+$(this).attr('src')+'">');
});

$(window).scroll(function(){
  if($(window).scrollTop() > $('.trigger:last').offset().top - $(window).height() && intermittent && nextPage > 0){
    intermittent = false;
    $.ajax({
      type: 'GET',
      url: '/forumlist/',
      dataType: 'html',
      data: {
        page: nextPage
      },
      success: function(data) {
        $('#timeline_frame').append($(data).find('#timeline_frame div'));
        nextPage = $(data).find('#nextPage').html();
        intermittent = true;
      }
    });
  }
});

$('.goDetail').click(function(){
  if($(this).attr('q-id') > 0){
    location.href = '/quiz/?q='+$(this).attr('q-id');
  }else{
    location.href = '/forum/?f='+$(this).attr('f-id');
  }
});

