if(getVal.warn){
  alert('他のアカウントのログアウト・削除してから、ログイン・同期してください');
  location.href = '/myprofile/';
}
if($.cookie('follow')){
  localStorage.follow = $.cookie('follow');
  $.cookie('follow','',{expires:-1,path:'/'});
}
if($.cookie('myname')){
  localStorage.myname = $.cookie('myname');
  $.cookie('myname','',{expires:-1,path:'/'});
}
if($.cookie('myphoto')){
  localStorage.myphoto = $.cookie('myphoto');
  $.cookie('myphoto','',{expires:-1,path:'/'});
}
if($.cookie('point')){
  localStorage.point = $.cookie('point');
  $.cookie('point','',{expires:-1,path:'/'});
}
if($.cookie('ua_u_id')){
  localStorage.ua_u_id = $.cookie('ua_u_id');
  $.cookie('ua_u_id','',{expires:-1,path:'/'});
}
if($.cookie('answer_by_u')){
  localStorage.answer_by_u = $.cookie('answer_by_u');
  $.cookie('answer_by_u','',{expires:-1,path:'/'});
}
if($.cookie('answer')){
  localStorage.answer = $.cookie('answer');
  $.cookie('answer','',{expires:-1,path:'/'});
}
function get_eto(u_id){
  left   = Math.floor( u_id / 100).toString().substr(-1);
  left   = decimal_hexadecimal(left);
  middle = Math.floor(u_id / 10).toString().substr(-1);
  middle = decimal_hexadecimal(middle);
  right  = Math.floor(u_id / 1).toString().substr(-1);
  right  = decimal_hexadecimal(right);

  eto_num = ( u_id % 12 ) + 1;
  switch (eto_num) {
    case 1:
      eto_img = '/assets/img/eto/01_rat.png';
      eto_txt = 'ねずみ';
      break;
    case 2:
      eto_img = '/assets/img/eto/02_buffalo.png';
      eto_txt = 'うし';
      break;
    case 3:
      eto_img = '/assets/img/eto/03_tiger.png';
      eto_txt = 'とら';
      break;
    case 4:
      eto_img = '/assets/img/eto/04_rabbit.png';
      eto_txt = 'うさぎ';
      break;
    case 5:
      eto_img = '/assets/img/eto/05_dragon.png';
      eto_txt = 'たつ';
      break;
    case 6:
      eto_img = '/assets/img/eto/06_snake.png';
      eto_txt = 'へび';
      break;
    case 7:
      eto_img = '/assets/img/eto/07_horse.png';
      eto_txt = 'うま';
      break;
    case 8:
      eto_img = '/assets/img/eto/08_sheep.png';
      eto_txt = 'ひつじ';
      break;
    case 9:
      eto_img = '/assets/img/eto/09_monkey.png';
      eto_txt = 'さる';
      break;
    case 10:
      eto_img = '/assets/img/eto/10_hen.png';
      eto_txt = 'とり';
      break;
    case 11:
      eto_img = '/assets/img/eto/11_dog.png';
      eto_txt = 'いぬ';
      break;
    case 12:
      eto_img = '/assets/img/eto/12_pig.png';
      eto_txt = 'いのしし';
      break;
  }
  var eto = [];
  eto[0] = u_id;
  eto[1] = eto_txt+u_id;
  eto[2] = eto_img;
  eto[3] = 'style="background-color:#'+left+left+middle+middle+right+right+';opacity:0.7;"';
  return eto;
}
function decimal_hexadecimal(res)
{
  switch (res) {
    case 1:
      res = 'A';
      break;
    case 3:
      res = 'B';
      break;
    case 5:
      res = 'C';
      break;
    case 7:
      res = 'D';
      break;
    case 9:
      res = 'E';
      break;
  }
  return res;
}
function highlighting(highlight,sc_height,drawer_open){
  scrollTo(0,sc_height);
  if (matchMedia('only screen and (max-width : 710px)').matches && drawer_open) {
    $('#drawer').css({
      'left': -1
    });
  }
  drawerIsOpen = drawer_open;
  var limit = 0;
  while(limit < 3){
    $(highlight).fadeOut(1000,function(){
      $(this).css("background-color","yellow");
    }).fadeIn(1000);
    ++limit;
  }
}

if(localStorage.quest){
  var quest = JSON.parse(localStorage.quest);
  if(quest[2] != 1){
    quest[2] = 1;
    localStorage.quest = JSON.stringify(quest);
    setTimeout(function(){
      highlighting('#page_quest',200,true);
    },3000);
  }
}
if(localStorage.myphoto){
  $('#photo').attr('src',localStorage.myphoto);
  $('#myname').val(localStorage.myname);
}else if(localStorage.ua_u_id){
  var eto = get_eto(localStorage.ua_u_id);
  $('#photo').attr('src',eto[2]); 
  $('#myname').val(eto[1]);
  $('#photo').css({
    'background-color':eto[3]
    ,'opacity':'0.7'
  });
}

if(localStorage.follow){
  var follow = JSON.parse(localStorage.follow);
  $('#num_following').empty().append(follow.length); 
}

$('.auth').click(function(){
  r = confirm('ログイン・同期します');
  if(r){
    (localStorage.myphoto)? myphoto = localStorage.myphoto : myphoto = '';
    (localStorage.myname)? myname = localStorage.myname : myname = '';
    (localStorage.answer_by_u)? answer_by_u = localStorage.answer_by_u : answer_by_u = [];
    (localStorage.answer)? answer = localStorage.answer : answer = [];
    var param = {
      csrf : $.cookie('csrf')
      ,myphoto : myphoto
      ,myname : myname
      ,answer_by_u : answer_by_u
      ,answer : answer
    };
    var this_url = $(this).data('url');
    $.post('/mydataedit/',param,function(){},"json")
    .always(function(res){
      if(res[0]==1){
        location.href = this_url;
      }else if(res[0]==2){
        alert('connection error');
      }
    });
    ga('set', 'dimension10',$(this).attr('alt'));
    ga('send','event','auth',$(this).attr('alt'),localStorage.ua_u_id,1);
  }
});

var childWindow;
$('#photo').click(function() {
  if(!u_id){
    alert('はじめにクイズに答えてください');
    return;
  }
  childWindow = window.open("/htm/photo/", "winB");
});
function winCloseB(){
  childWindow.close();
  var param = {
    csrf : $.cookie('csrf')
    ,img : localStorage.getItem('img')
  };
  $.ajax({type:'POST',dataType:'json',url:'/photoprofileadd/',data:param})
  .always(function(data){
    if(data[0] == 1){
      localStorage.myphoto = data[1];
    }else{
      console.log(data);
      alert('connection error');
    }
  });
}

$('#generate').click(function(){
  if(!u_id){
    alert('はじめにクイズに答えてください');
    return;
  }
  var validate = 1;
  if($('#myname').val()==''){
    $('#myname').css({'background-color':'red'});
    validate=2;
  }
  if(!localStorage.myphoto){
    $('#photo_res').css({'background-color':'red'});
    validate=2;
  }
  if(validate==2){
    return;
  }
  r = confirm('プロファイルを変更します');
  if(r){
    $('#generate').css({'display': 'none'});  
    $('#success').css({'display': ''});
    var param = {
      csrf : $.cookie('csrf')
      ,myname : $('#myname').val()
      ,introduce:  $('#introduce').val()
      ,myphoto : localStorage.myphoto
    };
    $.post('/myprofileadd/',param,function(){},"json")
    .always(function(res){
      if(res[0]==1){
        localStorage.removeItem('img');
        localStorage.myname = $('#myname').val();
        location.href='';
      }else{
        $('#success').css({'display': 'none'});
        $('#generate').css({'display': ''});  
        alert('connection error');
      }
    });
    ga('send','event','myprofile','upload','edit',1);
  }
});

function checkClick(){
  $('#generate').css({'display': 'none'});  
  $('#delete').css({'display': ''});
  var check_empty = 1;
  $('[name="quiz_id"]:checked').each(function(){
    check_empty = 0;
  });
  if(check_empty == 1){
    $('#delete').css({'display': 'none'});
    $('#generate').css({'display': ''});  
  }
}

$('#delete').click(function(){
  r = confirm('削除します');
  if(r){
    var quiz_id=[];
    $('[name="quiz_id"]:checked').each(function(){
      quiz_id.push($(this).val());
    });
    var param = {
      csrf : $.cookie('csrf')
      ,quiz_id : quiz_id
    };
    $.post('/myquizdelete/',param,function(){},"json")
    .always(function(res){
      if(res[0]==1){
        location.href='';
      }
    });  
  }
});

$('#del_cookie').click(function(){
  r = confirm('ログアウト・削除します');
  if(r){
    localStorage.clear();
    $.post('/myprofiledel/',{csrf:$.cookie('csrf')},function(){},"json")
    .always(function(res){
      if(res[0]==1){
        location.href='';
      }
    });
  }
});

var endTime = Math.round( new Date().getTime() / 1000 );
endTime = endTime + 86400 * 20;
var addLimit = 20;
var celNum = 0;
var resData = [];
function addCel(resData){
  while(celNum < addLimit){
    var cellId = resData[celNum][0];
    var cellTxt = resData[celNum][1];
    if(resData[celNum][2]){
      var append = 
      '<tr><td class="td_15_c">'+
      '<a href="/quiz/?crypt_q='+resData[celNum][2]+'">'+
      '<img src="'+resData[celNum][2]+'" alt="quiz" class="icon"></a>'+
      '</td><td class="td_68_c">'+
      '<a href="/quiz/?crypt_q='+resData[celNum][3]+'">'+
      '<input type="text" value="'+cellTxt+'" readonly class="input_txt_c"></a>'+
      '</td><td class="td_15_c" onClick="checkClick()">'+
      '<input type="checkbox" name="quiz_id" class="icon" value="'+cellId+'">'+
      '</td></tr>';
    }else{
      var append = 
      '<tr><td colspan="2" class="td_84_ct">'+
      '<a href="/quiz/?crypt_q='+resData[celNum][3]+'">'+
      '<input type="text" value="'+cellTxt+'" readonly class="input_txt_c"></a>'+
      '</td><td class="td_15_c" onClick="checkClick()">'+
      '<input type="checkbox" name="quiz_id" class="icon" value="'+cellId+'">'+
      '</td></tr>';
    }
    $('#cel').append(append);
    ++celNum;
    if(!resData[celNum]){
      return;
    }
  }
}

function getData(first){
  var param = {
    endTime : endTime
  };
  $.get('/myquestionshow/',param,function(){},"json")
  .always(function(res){
//     resData = id, txt, img
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

var dataLimit = 80;
$(function(){
  getData(1);
  var detect = 300;
  $(window).scroll(function(){
    var scrTop = $(document).scrollTop();
    if(scrTop > detect){
      detect = detect + 300;
      addLimit = addLimit + 20;
      if(addLimit > dataLimit){
        dataLimit = dataLimit + 80;
        getData();
      }
      if(resData[celNum]){
        addCel(resData);
      }
    }
  });
});
//if(localStorage.quest){
//  var quest = JSON.parse(localStorage.quest);
//  quest[3][1] = '<img src="/assets/img/icon/circle_big.png" class="icon">';
//  localStorage.quest = JSON.stringify(quest);
//}else{
//  var quest = [];
//  quest[0][0] = 'クイズに答える';
//  quest[0][1] = '<img src="/assets/img/icon/circle_big.png" class="icon">';
//  quest[1][0] = '<a href="/top/">他のクイズを確認</a>';
//  quest[1][1] = '<img src="/assets/img/icon/success_0.png" class="icon">';
//  quest[2][0] = '<a href="/myanswer/">マイアンサー(復習)を確認</a>';
//  quest[2][1] = '<img src="/assets/img/icon/success_0.png" class="icon">';
//  quest[3][0] = '<a href="myprofile">マイプロファイルを確認</a>';
//  quest[3][1] = '<img src="/assets/img/icon/circle_big.png" class="icon">';
//  localStorage.quest = JSON.stringify(quest);
//}

ga('send', 'pageview');