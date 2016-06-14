quizUsrShow();
answer_by_q_show();
tag_show();

function shuffle(array) {
  var m = array.length, t, i;
  while (m) {
    i = Math.floor(Math.random() * m--);
    t = array[m];
    array[m] = array[i];
    array[i] = t;
  }
  return array;
}
localStorage.last_q = q_id;

var rand_ch = [0,1,2,3];
rand_ch = shuffle(rand_ch);
var q = [$('#choice_0').html(),$('#choice_1').html(),$('#choice_2').html(),$('#choice_3').html()];
$('#choice_0').empty().append(q[rand_ch[0]]);
$('#choice_1').empty().append(q[rand_ch[1]]);
$('#choice_2').empty().append(q[rand_ch[2]]);
$('#choice_3').empty().append(q[rand_ch[3]]);

var comment_offline = '';
$(".comment").each(function(i){
  comment_offline = comment_offline+$(this).html();
});

if(localStorage.ticket){
  var ticket = JSON.parse(localStorage.ticket);
  if(ticket[0] > 0){
    $('#ticket').css({ 'color': 'green' });
    $('#ticket').empty().append(ticket[0]);
  }
}else{
  var ticket = [10,1,hour_stamp,10];
  localStorage.ticket = JSON.stringify(ticket);
  $('#ticket').css({ 'color': 'green' });
  $('#ticket').empty().append(10);
}
ga('set', 'dimension7',q_id);
if(localStorage.ua_u_id && localStorage.ua_u_id == usr){
  ga('set','dimension12','owner');
  //ga('set', 'metric1', usr);
}

if(localStorage.offline_q){
  var offline_q = JSON.parse(localStorage.offline_q);
}else{
  var offline_q = [];
}

var already = 0;
for(var i = 0; i < offline_q.length; i++){
  if(offline_q[i][7] == q_id){
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
      location.href = '/htm/quest/';
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
  if($('#correct').html() == $(this_seq).html()){
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
    if($('#correct').html() == $('#choice_'+i).html()){
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
    ,choice_0 : $('#choice_0').html()
    ,choice_1 : $('#choice_1').html()
    ,choice_2 : $('#choice_2').html()
    ,choice_3 : $('#choice_3').html()
    ,comment : comment_offline
    ,myanswer : $(this_seq).html()
    ,correct_choice : $('#correct').html()
    ,quiz_num : quiz_num
  };
  if(already < 1){
    $.post('/answer/',param,function(){},"json")
    .always(function(res){
      if(res[0]==1){
      }else{
      }
    });
    offline_q.unshift([
      $('#question').html()
      ,$('#choice_0').html()
      ,$('#choice_1').html()
      ,$('#choice_2').html()
      ,$('#choice_3').html()
      ,$('#correct').html()
      ,q_img
      ,q_id
      ,comment_offline
      ,$(this_seq).html()
      ,quiz_num
    ]);
    if(offline_q.length > 199){
      var diff = offline_q.length - 200;
      offline_q.splice(-diff, diff);
    }
  }else{
    for(var i = 0; i < offline_q.length; i++){
      if(offline_q[i][7] == q_id){
        offline_q[i] = [
          $('#question').html()
          ,$('#choice_0').html()
          ,$('#choice_1').html()
          ,$('#choice_2').html()
          ,$('#choice_3').html()
          ,$('#correct').html()
          ,q_img
          ,q_id
          ,comment_offline
          ,$(this_seq).html()
          ,quiz_num
        ];
      }
    }
  }
  localStorage.offline_q = JSON.stringify(offline_q);
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
  ticket[0]--;
  localStorage.ticket = JSON.stringify(ticket);
  setTimeout(function(){
    if(next_q){
      if(iframe){
        top.window.location.href = 'http://'+domain+'/quiz/?q='+next_q;        
      }else{
        location.href = '/quiz/?q='+next_q;
      }
    }else{
      location.href = '/';
    }
  },1000);
}
$('#sns td a').click(function(){
  if(localStorage.quest){
    var quest = JSON.parse(localStorage.quest);
    if(quest[5] != 1){
      quest[5] = 1;
      localStorage.quest = JSON.stringify(quest);
      var ticket = JSON.parse(localStorage.ticket);
      ticket[0] = ticket[0] + 3;
      localStorage.ticket = JSON.stringify(ticket);
      notify[2] = 'yet';
      notify[3] = 1;
      notify[4] = notify[4]+1;
      if(localStorage.news){
        var news = JSON.parse(localStorage.news);
      }else{
        var news = [];
      }
      news.unshift('<a href="/htm/quest/">クイズをシェアしました<img src="/assets/img/icon/star_1.png"></a>');
      localStorage.news = JSON.stringify(news);
      localStorage.notify = JSON.stringify(notify);
    }
  }
  ga('set','dimension9','share_'+$(this).children('img').attr('alt'));  
  ga('send','event','share',$(this).children('img').attr('alt'),q_id,1);  
});

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
      $('#generator').append(append);
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
var next_q = 0;
var quiz_num = 0;
function tag_show(){
  var param = {
    q : q_id
  };
  $.get('/tagshow/',param,function(){},"json")
  .always(function(res){
    if(res[0]==1){
      for(i = 0; i < res[1].length; i++){
        $('#tag').append('&nbsp;<a href="/search/?tag='+res[1][i]['txt']+'">#'+res[1][i]['txt']+'</a>&nbsp;');
        ga('set','dimension13',res[1][i]);
      }
      $('#question').prepend('第'+res[1][0]['quiz_num']+'問.');
      quiz_num = res[1][0]['quiz_num'];
      if(res[3] && res[3][0]){
        next_q = res[3][0];
      }
      addNavi(res,3);
      addNavi(res,2);
    }else{
     //console.log(res);
    }
  });
}
function addNavi(res,nextPrev) {
  if(!res[nextPrev] || !res[nextPrev][0]){
    return;
  }
  var append = '';
  if(res[nextPrev][2]){
    append = 
    '<tr><td colspan="15" class="td_15_t">'+
    '<a href="/quiz/?q='+res[nextPrev][0]+'">'+
    '<img src="'+res[nextPrev][2]+'" alt="quiz" class="icon"></a>'+
    '</td><td colspan="85" class="td_84_t">'+
    '<a href="/quiz/?q='+res[nextPrev][0]+'">'+
    res[nextPrev][3]+'問. '+decodeURIComponent(res[nextPrev][1])+
    '</a>'+
    '</td>'+
    '</tr>';
  }else{
    append = 
    '<tr><td colspan="100" class="td_84_t">'+
    '<a href="/quiz/?q='+res[nextPrev][0]+'">'+
    res[nextPrev][3]+'問. '+decodeURIComponent(res[nextPrev][1])+
    '</a>'+
    '</td>'+
    '</tr>';
  }
  $('#next_prev').append(append);
}
$('#comment_add').click(function(){
  if(!u_id){
    alert('はじめにクイズに答えてください');
    return;
  }
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
    if(quest[6] != 1){
      quest[6] = 1;
      localStorage.quest = JSON.stringify(quest);
      notify[2] = 'yet';
      notify[3] = 1;
      notify[4] = notify[4]+1;
      if(localStorage.news){
        var news = JSON.parse(localStorage.news);
      }else{
        var news = [];
      }
      news.unshift('<a href="/htm/quest/">コメントしました<img src="/assets/img/icon/star_1.png"></a>');
      localStorage.news = JSON.stringify(news);
      localStorage.notify = JSON.stringify(notify);
    }
  }
  $('#comment_add').css({'display': 'none'});
  $('#success').css({'display':''});
  if(localStorage.myphoto){
    var myphoto = localStorage.myphoto;
  }else{
    var myphoto = '/assets/img/icon/guest.png';
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
