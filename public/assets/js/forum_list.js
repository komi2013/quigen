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
    news.unshift('<a href="/htm/quest/">chat is completed<img src="/assets/img/icon/star_1.png"></a>');
    localStorage.news = JSON.stringify(news);
    localStorage.notify = JSON.stringify(notify);
  }
}

/* rank */
if(localStorage.last_tag){
  $('#tag_name').val( localStorage.last_tag );
}
$('#tag_name').change(function () {
  if( !$('#tag_name').val() || $('#tag_name').val() == localStorage.last_tag){
    return;
  }
  localStorage.last_tag = $('#tag_name').val();
  location.href = '';    
}).change();

var endTime = Math.round( new Date().getTime() / 1000 );
var addLimit = 20;
var celNum = 0;
var resData = [];

function addCel(resData){
  while(celNum < addLimit){
    var append = 
    '<tr><td class="td_15_t">'+
    '<a href="/profile/?u='+resData[celNum][0]+'">'+
    '<img src="'+resData[celNum][2]+'" alt="usr" class="icon" '+resData[celNum][4]+'></a>'+
    '</td><td class="td_50_t">'+
    '<a href="/profile/?u='+resData[celNum][0]+'">'+resData[celNum][1]+'</a>'+
    '</td><td class="td_15_t">'+resData[celNum][3]+
    '</td><td class="td_15_t">'+'<img src="/assets/img/icon/circle_big.png" alt="correct" class="icon">'+
    '</td></tr>';

    $('#cel').append(append);
    ++celNum;
    if(!resData[celNum]){
      return;
    }
  }
}
var last_tag = (localStorage.last_tag)? localStorage.last_tag : '';
if(last_tag){
  function getData(first){
    var param = {
      endTime : endTime
      ,tag : last_tag
    };
    $.get('/rankshow/',param,function(){},"json")
    .always(function(res){
  //     resData = id, txt, img, crypt, endtime
      if(res[0]==1){
        resData = $.merge($.merge([], resData), res[1]);
        endTime = res[1].pop()[4];
        if(first == 1){
          addCel(resData);
        }
      }else if(res[0]==2){
      }
    });
  }
}

var dataLimit = 80;
$(function(){
  getData(1);
});

