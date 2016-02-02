var next_q = 0;
var q_id = getVal.q;
if(localStorage.offline_q){
  var offline_q = JSON.parse(localStorage.offline_q);
  var prev = 0;
  for(var i = 0; i < offline_q.length; i++){
    if(offline_q[i][7] == q_id){
      var q_txt = offline_q[i][0];
      var ch_0 = offline_q[i][1];
      var ch_1 = offline_q[i][2];
      var ch_2 = offline_q[i][3];
      var ch_3 = offline_q[i][4];
      var correct = offline_q[i][5];
      var q_img = offline_q[i][6];
      if(i > 0){
        next_q = offline_q[i-1][7];
      }
    }
  }
  $('#question').empty().append(q_txt);
  $('#choice_0').empty().append(ch_0);
  $('#choice_1').empty().append(ch_1);
  $('#choice_2').empty().append(ch_2);
  $('#choice_3').empty().append(ch_3);
  document.title = q_txt.slice(0,30);
  if(q_img){
    $('#photo').attr({'src':q_img});
  }else{
    $('#div_photo').empty();
  }
}
var usr = '';
var q_data = '';
var u_id = '';
var csrf = '';
var iframe = '';
var domain = '';

quizUsrShow();
answer_by_q_show();
tag_show();

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
var hour_stamp = Math.floor(new Date().getTime() /1000 /60 /60);
//if(localStorage.ticket){
//  var ticket = JSON.parse(localStorage.ticket);
//  if(ticket[0] > 0){
//    $('#ticket').css({ 'color': 'green' });
//    $('#ticket').empty().append(ticket[0]);
//  }
//}else{
//  var ticket = [10,1,hour_stamp,10];
//  localStorage.ticket = JSON.stringify(ticket);
//}
ga('set', 'dimension7',q_id);
if(localStorage.ua_u_id && localStorage.ua_u_id == usr){
  ga('set','dimension12','owner');
  //ga('set', 'metric1', usr);
}

if(localStorage.answer){
  var answer = JSON.parse(localStorage.answer);
}else{
  var answer = [];
}

var already = 0;
for(var i = 0; i < answer.length; i++){  
  if(answer[i][0] == q_id){
    already = 1;
  }
}  
var clicked = 0;
$('.choice').click(function(){
  if(clicked == 2){
    return;
  }
  clicked = 2;
  $(this).css({
    'background-color': 'grey',
    'border-width': '1px 1px',
    'border-color': 'silver',
    'border-style': 'solid'
  });
  var this_seq = $(this);
//  if(ticket[0] < 1){
//    $('#ticket').css({ 'color': 'red' });
//  }
//  $('#ticket').empty().append(ticket[0] -1);
  setTimeout(function(){
    answer_1(this_seq);
  },1000);
//  if(ticket[0] < 1){
//    setTimeout(function(){
//      location.href = '/htm/quest/?q='+q_id;
//      return;
//    },1000);
//  }else{
//    setTimeout(function(){
//      answer_1(this_seq);
//    },1000);    
//  }
});

function answer_1(this_seq){
  if(localStorage.myphoto){
    var myphoto = localStorage.myphoto;
    var eto_css = '';
  }else if(localStorage.ua_u_id){
    var eto = get_eto(localStorage.ua_u_id);
    var myphoto = eto[2];
    var eto_css = eto[3];
  }else{
    var myphoto = '/assets/img/icon/guest.png';
    var eto_css = '';
  }
  if(correct == $(this_seq).html()){
    var correct_answer = 1;
    resCo.unshift([0,'',myphoto,'',eto_css]);
    amt_co++;
    $('#big_correct').css({'display': ''});
  }else{
    var correct_answer = 0; 
    resInco.unshift([0,'',myphoto,'',eto_css]);
    $('#big_incorrect').css({'display': ''});
  }
  $(this_seq).css({
    'background-color': 'red',
    'border-width': '1px 1px',
    'border-color': 'silver',
    'border-style': 'solid'
  });
  
  $('.choice').each(function(i){
    if(correct == $('#choice_'+i).html()){
      $('#choice_'+i).css({
        'background-color': 'lime',
      });
    }
  });

  if(correct_answer == 1){
    addCel(resCo,'co');
  }else{
    addCel(resInco,'inco');
  }
  var tag = [];
  $('#tag a').each(function(i){
    tag[i] = $(this).html();
    localStorage.last_tag = $(this).html();
  });
  var q_img = ($('#photo').attr('src'))? $('#photo').attr('src') : '' ;
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
    ,correct : correct_answer
    ,question : q_id
    ,q_txt : $('#question').html()
    ,q_img : q_img
    ,generator : usr
    ,arr_tag : tag
    ,u_img : myphoto
    ,u_name : myname
  };
  if(already < 1){
//    $.post('/answer/',param,function(){},"json")
//    .always(function(res){
//      if(res[0]==1){
//      }else{
//      }
//    });
    answer.unshift([q_id,$(this_seq).html(),$('#question').html(),q_img,correct]);
    if(answer.length > 99){
      var diff = answer.length - 100;
      answer.splice(-diff, diff);
    }
    localStorage.answer = JSON.stringify(answer);
  }else{
    for(var i = 0; i < answer.length; i++){  
      if(answer[i][0] == q_id){
        answer[i] = [q_id,$(this_seq).html(),$('#question').html(),q_img,correct];
      }
    }
    localStorage.answer = JSON.stringify(answer);
  }
  amt_answer++;  
  after_post(correct_answer);
}
function after_post(correct_answer){
  $('#num_ratio').empty().append(Math.round(amt_co/amt_answer * 100)+' %');
  $('#num_answer').empty().append(amt_answer);
  if(localStorage.answer_by_u){
    var answer_by_u = JSON.parse(localStorage.answer_by_u);
    answer_by_u = [(answer_by_u[0] + correct_answer),(answer_by_u[1] + 1)];
  }else{
    var answer_by_u = [correct_answer, 1];
  }
  localStorage.answer_by_u = JSON.stringify(answer_by_u);
  if(answer_by_u[1] > 9){
    var u_answer = answer_by_u[1] / 10;
    u_answer = Math.floor(u_answer) * 10;
  }else{
    var u_answer = answer_by_u[1];
  }
  localStorage.session_answer = localStorage.session_answer*1 + 1;
  ga('set', 'dimension1',localStorage.session_answer);  
  ga('send','event','answer',correct_answer,usr,u_answer);
  var hour_stamp = Math.floor(new Date().getTime() /1000 /60 /60); 
  var notify = JSON.parse(localStorage.notify);
  notify[1] = hour_stamp+1;
  localStorage.notify = JSON.stringify(notify);
  //ticket[0]--;
  //localStorage.ticket = JSON.stringify(ticket);
  setTimeout(function(){
    if(next_q){
      location.href = '/htm/offline_quiz/?q='+next_q;
    }else{
      location.href = '/';
    }
  },1000);
}
$('#sns td a').click(function(){
  if(localStorage.quest){
    var quest = JSON.parse(localStorage.quest);
    quest[5] = 1;
    localStorage.quest = JSON.stringify(quest);
//    var ticket = JSON.parse(localStorage.ticket);
//    ticket[0] = ticket[0] + 3;
//    localStorage.ticket = JSON.stringify(ticket);
  }
  ga('set','dimension9','share_'+$(this).children('img').attr('alt'));  
  ga('send','event','share',$(this).children('img').attr('alt'),q_id,1);  
});

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

//.begin. add in/correct usr
var resCo = [];
var resInco = [];
function addCel(resData,coinco){
  var append = '';
  for (var celNum=0;celNum<resData.length;celNum++){
    append = '<a href="/profile/?u='+resData[celNum][0]+'">'+
    '<img src="'+resData[celNum][2]+'" alt="answered usr" class="ans_icon" '+resData[celNum][4]+' ></a>'+
    '</td>';
    $('#'+coinco+'_'+celNum).empty().append(append);
    if(celNum > 16){
      return;
    }
  }
}
//.end. add in/correct usr

function quizUsrShow(){
  var param = {
    q : q_id
  };
  var append = '';
  $.get('/quizusrshow/',param,function(){},"json")
  .always(function(res){
//     res[1] = id, txt, img
    if(res[0]==1){
      append = 
      '<a href="/profile/?u='+res[1][0]+'">'+
      '<img src="'+res[1][2]+'" alt="generator" class="icon" '+res[1][3]+'></a>';
      $('#right').append(append);
      addCel(res[2],'co');
      addCel(res[3],'inco');
      resCo = res[2];
      resInco = res[3];
    }else{
      console.log(res);
    }
  });
}

var amt_co = 0;
var amt_answer = 0;
function answer_by_q_show(){
  var param = {
    q : q_id
  };
  $.get('/answerbyqshow/',param,function(){},"json")
  .always(function(res){
    if(res[0]==1){
      amt_co = res[1][0];
      amt_answer = res[1][1];
      if(amt_co == 0){
        $('#num_ratio').empty().append(0+' %');
      }else{
        $('#num_ratio').empty().append(Math.round(amt_co/amt_answer * 100)+' %');
      }
      $('#num_answer').empty().append(amt_answer);
      
    }else{
     console.log(res);
    }
  });
}

function tag_show(){
  var param = {
    q : q_id
  };
  $.get('/tagshow/',param,function(){},"json")
  .always(function(res){
    if(res[0]==1){
      for(i = 0; i < res[1].length; i++){
        $('#tag').append('&nbsp;<a href="/search/?tag='+res[1][i]+'">#'+res[1][i]+'</a>&nbsp;');
        ga('set','dimension13',res[1][i]);
      }
      if(res[2][0]){
        $('#prev').append('<a href="/quiz/?q='+res[2][0]+'"> << </a>');
        //next_q = res[2][0];
      }
      if(res[2][1]){
        $('#next').append('<a href="/quiz/?q='+res[2][1]+'"> >> </a>');
        //next_q = res[2][1];
      }
    }else{
     //console.log(res);
    }
  });
}

$('#comment_add').click(function(){
  var validate = 1;
  if($('#comment_data').val()==''){
    $('#comment_data').css({'border-color':'red'});
    validate=2;
  }
  if(validate==2){
    return false;
  }
  if(localStorage.quest){
    var quest = JSON.parse(localStorage.quest);
    quest[6] = 1;
    localStorage.quest = JSON.stringify(quest);
  }
  $('#comment_add').css({'display': 'none'});
  $('#success').css({'display':''});
  if(localStorage.myphoto){
    var myphoto = localStorage.myphoto;
  }else{
    var myphoto = '';
  }
  var param = {
    csrf : csrf
    ,txt : $('#comment_data').val()
    ,q : q_id
    ,u_img : myphoto
  };
  $.post('/commentadd/',param,function(){},"json")
  .always(function(res){
    if(res[0]==1){
      location.href = '';
    }else{
      alert('connection error');
    }
  });
  ga('set','dimension14','comment');  
  ga('send','event','comment',usr,$('#comment_data').val(),1);  
  return false;
});

$('#report').click(function(){
  if(!u_id){
    alert('はじめにクイズに答えてください');
    return;
  }
  r = confirm('報告します');
  if(r){
    var param = {
      csrf : csrf
      ,q_id : q_id
    };
    $.post('/report/',param,function(){},"json")
    .always(function(res){
      if(res[0]==1){
        csrf = res[1];
      }else{
        alert('connection error');
      }
    });  
  }
  ga('set','dimension15','report');  
  ga('send','event','report',usr,'none','2');
  return false;
});
$('#0pt').click(function(){
  if(!u_id){
    alert('はじめにクイズに答えてください');
    return;
  }
  r = confirm('0ポイントで買取要求します');
  if(r){
    var q_img = ($('#photo').attr('src'))? $('#photo').attr('src') : '' ;
    var param = {
      csrf : csrf
      ,q_id: q_id
      ,q_txt : $('#question').html()
      ,q_img : q_img
      ,point: 0
      ,usr: usr
    };
    $.post('/quizbuy/',param,function(){},"json")
    .always(function(res){
      if(res[0]==1){
        csrf = res[1];
      }else{
        alert('connection error');
      }
    });
    
  }
  ga('set','dimension16','buy_0');  
  ga('send','event','buy_on_quiz',0,usr,1);  
  return false;
});
$('#20pt').click(function(){
  if(!localStorage.point || localStorage.point < 20){
    alert('ポイントが足りません');
    return;
  }
  if(!u_id){
    alert('はじめにクイズに答えてください');
    return;
  }
  r = confirm('20ポイントで買取要求します');
  if(r){
    var q_img = ($('#photo').attr('src'))? $('#photo').attr('src') : '' ;
    var param = {
      csrf : csrf
      ,q_id: q_id
      ,q_txt : $('#question').html()
      ,q_img : q_img
      ,point: 20
      ,usr: usr
    };
    $.post('/quizbuy/',param,function(){},"json")
    .always(function(res){
      if(res[0]==1){
        csrf = res[1];
      }else{
        alert('connection error');
      }
    });
  }
  ga('set','dimension16','buy_20');  
  ga('send','event','buy_on_quiz',20,usr,1);  
  return false;
});



