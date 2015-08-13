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
if(localStorage.ticket){
  var ticket = JSON.parse(localStorage.ticket);
  if(ticket[0] > 0){
    $('#ticket').css({ 'color': 'green' });
    $('#ticket').empty().append(ticket[0]);
  }
}else{
  var ticket = [2,1,hour_stamp,2];
  localStorage.ticket = JSON.stringify(ticket);
}
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
  if(ticket[0] < 1){
    $('#ticket').css({ 'color': 'red' });
  }
  $('#ticket').empty().append(ticket[0] -1);
  if(ticket[0] < 1){
    setTimeout(function(){
      location.href = '/htm/?p=quest&q='+q_id;
      return;
    },1000);
  }else{
    setTimeout(function(){
      answer_1(this_seq);
    },1000);    
  }
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
    csrf : $.cookie('csrf')
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
    $.post('/answer/',param,function(){},"json")
    .always(function(res){
      if(res[0]==1){
      }else{
      }
    });
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
  comment_show();
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
  answerStep(answer_by_u);
  var hour_stamp = Math.floor(new Date().getTime() /1000 /60 /60); 
  var notify = JSON.parse(localStorage.notify);
  notify[1] = hour_stamp+1;
  localStorage.notify = JSON.stringify(notify);
  ticket[0]--;
  ticket[2] = hour_stamp;
  localStorage.ticket = JSON.stringify(ticket);
}
$('#sns td a').click(function(){
  if(localStorage.quest){
    var quest = JSON.parse(localStorage.quest);
    quest[5] = 1;
    localStorage.quest = JSON.stringify(quest);
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
function answerStep(answer_by_u){
  setTimeout(function(){
    var highlight  = '';
    var sc_height = 0;
    var drawer_open = true;
    switch (answer_by_u[1]) {
      case 1:
        highlight = '#tag';
        sc_height = document.body.scrollHeight;
        drawer_open = false;
        highlighting(highlight,sc_height,drawer_open);
        highlight = '#prev';
        highlighting(highlight,sc_height,drawer_open);
        highlight = '#next';
        highlighting(highlight,sc_height,drawer_open);
      break;
      case 2:
        highlight = '#page_top';
        highlighting(highlight,sc_height,drawer_open);
      break;
//       case 3:
//         highlight = '#page_myanswer';
//         highlighting(highlight,sc_height,drawer_open);
//       break;
//       case 4:
//         highlight = '#right';
//         drawer_open = false;
//         highlighting(highlight,sc_height,drawer_open);
//       break;
//       case 5:
//         highlight = '#page_generate';
//         highlighting(highlight,sc_height,drawer_open);
//       break;
//       case 6:
//         highlight = '#page_gene4word';
//         highlighting(highlight,sc_height,drawer_open);
//       break;
//       case 7:
//         highlight = '#page_myprofile';
//         highlighting(highlight,sc_height,drawer_open);
//       break;
//       case 8:
//         highlight = '#page_rank';
//         highlighting(highlight,sc_height,drawer_open);
//       break;
//       case 9:
//         highlight = '#page_category';
//         highlighting(highlight,sc_height,drawer_open);
//       break;
    }
  }, 3000);
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
        $('#tag').append('&nbsp;<a href="/htm/?p=search&tag='+res[1][i]+'">#'+res[1][i]+'</a>&nbsp;');
        ga('set','dimension13',res[1][i]);
      }
      if(res[2][0]){
        $('#prev').append('<a href="/quiz/?q='+res[2][0]+'"> << </a>');
      }
      if(res[2][1]){
        $('#next').append('<a href="/quiz/?q='+res[2][1]+'"> >> </a>');
      }
    }else{
     //console.log(res);
    }
  });
}

function comment_show(){
  var param = {
    q : q_id
  };
  $.get('/commentshow/',param,function(){},"json")
  .always(function(res){
//     res[1] = id, txt, img
    if(res[0]==1){
      addCelComment(res[1]);
    }else if(res[0]==2){
      comment();
    }else{
      alert('connection error');
      //console.log(res);
    }
  });
}

function addCelComment(resData){
  var cellTxt = '';
  var celImg = '';
  var eto_css = '';
  for (var celNum=0;celNum<resData.length;celNum++){
    cellId = resData[celNum][0];
    cellTxt = resData[celNum][1];
    if(resData[celNum][2]){
      celImg = resData[celNum][2];
    }else{
      var eto = get_eto(resData[celNum][0]);
      celImg = eto[2];
      eto_css = eto[3];
    }
    var append = 
    '<tr><td class="td_15_c">'+
    '<a href="/profile/?u='+cellId+'" >'+
    '<img src="'+celImg+'" alt="follower photo" class="icon" '+eto_css+'></a>'+
    '</td><td class="td_84_ct">'+cellTxt+'</td></tr>';
    $('#comment').append(append);
  }
  comment();
}
function comment(){
  var append = '<tr><td><input type="text" placeholder="コメント" class="txt_84" id="comment_data"></td><td>'+
    '<img src="/assets/img/icon/upload_0.png" alt="comment" class="icon" id="comment_add">'+
    '<img src="/assets/img/icon/success.png" alt="success" class="icon" id="success" style="display:none;">'+
    '</td></tr>';
  $('#comment_in').append(append);
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
    var param = {
      csrf : $.cookie('csrf')
      ,txt : $('#comment_data').val()
      ,q : q_id
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
}

function commentAdd(){
  var param = {
    q : q_id
  };
  $.get('/commentshow/',param,function(){},"json")
  .always(function(res){
//     res[1] = id, txt, img
    if(res[0]==1){
      addCelComment(res[1]);
    }else{
      alert('connection error');
      console.log(res);
    }
  });  
}
$('#report').click(function(){
  if(!u_id){
    alert('はじめにクイズに答えてください');
    return;
  }
  r = confirm('報告します');
  if(r){
    var param = {
      csrf : $.cookie('csrf')
      ,q_id : q_id
    };
    $.post('/report/',param,function(){},"json")
    .always(function(res){
      if(res[0]==1){
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
      csrf : $.cookie('csrf')
      ,q_id: q_id
      ,q_txt : $('#question').html()
      ,q_img : q_img
      ,point: 0
      ,usr: usr
    };
    $.post('/quizbuy/',param,function(){},"json")
    .always(function(res){
      if(res[0]==1){
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
      csrf : $.cookie('csrf')
      ,q_id: q_id
      ,q_txt : $('#question').html()
      ,q_img : q_img
      ,point: 20
      ,usr: usr
    };
    $.post('/quizbuy/',param,function(){},"json")
    .always(function(res){
      if(res[0]==1){
      }else{
        alert('connection error');
      }
    });
  }
  ga('set','dimension16','buy_20');  
  ga('send','event','buy_on_quiz',20,usr,1);  
  return false;
});
setTimeout(function(){
  if(typeof ga == "function"){
    ga('send', 'pageview');
  }
},1000);



