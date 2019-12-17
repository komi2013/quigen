quizUsrShow();
answer_by_q_show();
tag_show();

$('.textbox').hide();
$('.choice_q').hide();
$('.alter_an').hide();
var click_ele = '#descriptive';
var clicked = 0;
if(!$('table').hasClass('choice_q')){
  $('a').css({ 'pointer-events': 'none' });
  setTimeout(function(){
    $('a').css({ 'pointer-events': 'none' });
  },2000);
  clicked = 2;
  click_ele = '.choice';
} else if (!$('#choice_1').text()) {
  $('.textbox').show();
} else if (localStorage.an_type == 'choice_an') {
  $('.choice_q').show();
  $('.alter_an').show();
  $('#choice_q').addClass("this_page");
  $('#textbox').addClass("another_page");
  click_ele = '.choice';
} else {
  $('.textbox').show();
  $('.alter_an').show();
  $('#choice_q').addClass("another_page");
  $('#textbox').addClass("this_page");
}

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

var offline_q = localStorage.offline_q ? JSON.parse(localStorage.offline_q) : [];

var already = 0;
for(var i = 0; i < offline_q.length; i++){
  if(offline_q[i][7] == q_id){
    already = 1;
  }
}

$(click_ele).click(function(){
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
  var this_seq = click_ele == '#descriptive' ? $('#txt_answer') : $(this);
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
    answer_day();
  }
});
var last_answer_stamp = Math.floor(new Date().getTime() /1000);
function answer_day(){
  var answer_stamp = Math.floor(new Date().getTime() /1000);
  var day_stamp = Math.round(answer_stamp /60 /60 /24);
  var day_sum = {};
  var arr_stamp = [0,0];
  if(localStorage.day_sum){
    day_sum = JSON.parse(localStorage.day_sum);
    if(day_sum[day_stamp]){
      arr_stamp = day_sum[day_stamp];
    }
  }
  arr_stamp[0] = arr_stamp[0] + 1;
  arr_stamp[1] = arr_stamp[1] + answer_stamp - last_answer_stamp;
  day_sum[day_stamp] = arr_stamp;
  localStorage.day_sum = JSON.stringify(day_sum);
}
var audio_correct = document.getElementById("audio_correct");
var audio_incorrect = document.getElementById("audio_incorrect");
function answer_1(this_seq){
  var ans_photo = myphoto ? myphoto : '/assets/img/icon/guest.png';
  if($('#correct').html() == $(this_seq).html() || 
          ($('#correct').text() == $(this_seq).text() && $('#correct').text())){
    var correct_answer = 1;
    resCo.unshift([0,'',ans_photo,'',mybgcolor]);
    amt_co++;
    $('#big_correct').css({'display': ''});
    $(this_seq).css({'background-color': 'lime'});
    audio_correct.play();
  }else{
    var correct_answer = 0; 
    resInco.unshift([0,'',ans_photo,'',mybgcolor]);
    $('#big_incorrect').css({'display': ''});
    $(this_seq).css({'background-color': 'red'});
    if(click_ele === '#descriptive'){
      $('#correct').css({
        'display': '',
        'background-color': 'lime'
      });
    }
    audio_incorrect.play();
  }

  $(this_seq).css({
    'border-width': '1px 1px',
    'border-color': 'silver',
    'border-style': 'solid'
  });
  $('.cho_pic').css({ 'opacity': '0.3' });
  $('.choice').each(function(i){
    if($('#correct').html() == $('#choice_'+i).html()){
      $('#choice_'+i).css({
          'background-color':'lime',
          'opacity':'1'
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
  var myphoto_ans = localStorage.myphoto ? localStorage.myphoto : '';
  var myname_ans = localStorage.myname ? localStorage.myname : '';
  var param = {
    csrf : csrf
    ,correct : correct_answer
    ,question : q_id
    ,q_txt : $('#question').html()
    ,q_img : q_img
    ,generator : usr
    ,arr_tag : tag
    ,u_img : myphoto_ans
    ,u_name : myname_ans
    ,choice_0 : $('#choice_0').text() || $('#choice_0 img').attr('src')
    ,choice_1 : $('#choice_1').text() || $('#choice_1 img').attr('src')
    ,choice_2 : $('#choice_2').text() || $('#choice_2 img').attr('src')
    ,choice_3 : $('#choice_3').text() || $('#choice_3 img').attr('src')
    ,comment : comment_offline
    ,myanswer : $(this_seq).text() || $(this_seq).children('img').attr('src')
    ,correct_choice : $('#correct').text() || $('#correct img').attr('src')
    ,quiz_num : quiz_num
  };
  var arr = [
      $('#question').html()
      ,$('#choice_0').text() || $('#choice_0 img').attr('src')
      ,$('#choice_1').text() || $('#choice_1 img').attr('src')
      ,$('#choice_2').text() || $('#choice_2 img').attr('src')
      ,$('#choice_3').text() || $('#choice_3 img').attr('src')
      ,$('#correct').text() || $('#correct img').attr('src')
      ,q_img
      ,q_id
      ,comment_offline
      ,$(this_seq).text() || $(this_seq).children('img').attr('src')
      ,quiz_num
    ];
  if(already < 1){
    $.post('/answer/',param,function(){},"json")
    .always(function(res){
      if(res[0]==1){
      }else{
      }
    });
    offline_q.unshift(arr);
    if(offline_q.length > 199){
      var diff = offline_q.length - 200;
      offline_q.splice(-diff, diff);
    }
  }else{
    for(var i = 0; i < offline_q.length; i++){
      if(offline_q[i][7] == q_id){
        offline_q[i] = arr;
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
        top.window.location.href = 'https://'+domain+'/quiz/?q='+next_q;        
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
      var news = localStorage.news ? JSON.parse(localStorage.news) : [];
      news.unshift('<a href="/htm/quest/">'+shared_quiz+'<img src="/assets/img/icon/star_1.png"></a>');
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
    ,u : usr
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
      $('#question').prepend(no_+res[1][0]['quiz_num']+mon+' ');
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
    no_+res[nextPrev][3]+mon+decodeURIComponent(res[nextPrev][1])+
    '</a>'+
    '</td>'+
    '</tr>';
  }else{
    append = 
    '<tr><td colspan="100" class="td_84_t">'+
    '<a href="/quiz/?q='+res[nextPrev][0]+'">'+
    no_+res[nextPrev][3]+mon+decodeURIComponent(res[nextPrev][1])+
    '</a>'+
    '</td>'+
    '</tr>';
  }
  $('#next_prev').append(append);
}
$('#comment_add').click(function(){
  if(!localStorage.login){
    alert(please_login);
    return;
  }
  var validate = 1;
  if($('#comment_data').val().length < 10){
    alert('you must input more');
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
      var news = localStorage.news ? JSON.parse(localStorage.news) : [];
      news.unshift('<a href="/htm/quest/">'+commented+'<img src="/assets/img/icon/star_1.png"></a>');
      localStorage.news = JSON.stringify(news);
      localStorage.notify = JSON.stringify(notify);
    }
  }
  $('#comment_add').css({'display': 'none'});
  $('#success').css({'display':''});
  var myphoto = localStorage.myphoto ? localStorage.myphoto : '';
  var myname = localStorage.myname ? localStorage.myname : '';
  var param = {
    csrf : csrf
    ,txt : $('#comment_data').val()
    ,q : q_id
    ,u_img : myphoto
    ,u_name : myname
  };
  $.post('/commentadd/',param,function(){},"json")
  .always(function(res){
    if(res[0]==1){
      location.reload();
    }else{
      alert('connection error');
    }
  });
  ga('set','dimension14','comment');  
  ga('send','event','comment',usr,$('#comment_data').val(),1);  
  return false;
});

$('.chg_an_type').click(function(){
  localStorage.an_type = $(this).attr('an_type');
  setTimeout(function(){
    location.href = "" ;
    return;
  },100);
});
if(sound){
    var a = document.getElementById("audio");
    var played = 0;
    $('#play').click(function(){
        if(played < 1){ a.play(); }
        setTimeout(function(){
          $('a').css({ 'pointer-events': '' });
          clicked = 0;
          played = 1;
        },2000);
        $('.cho_pic').css({ 'opacity': '1' });
    });
}
