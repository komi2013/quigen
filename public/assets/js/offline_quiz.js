var next_q = 0;
var q_id = localStorage.current_q;

if(localStorage.offline_q){
  var offline_q = JSON.parse(localStorage.offline_q);
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
  console.log(q_txt);
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
var u_id = localStorage.ua_u_id;
var csrf = '';
var iframe = '';

var fb_url   = 'http://www.facebook.com/sharer.php?u=http://'+domain+'/quiz/?q='+q_id+'%26cpn=share_fb';
var tw_url   = 'https://twitter.com/intent/tweet?url=http://'+domain+'/quiz/?q='+q_id+'%26cpn=share_tw&text='+q_txt+'+@quigen2015';
var ln_url   = 'line://msg/text/?'+q_txt+'%0D%0Ahttp://'+domain+'/quiz/?q='+q_id+'%26cpn=share_ln';
var clip_url = 'http://'+domain+'/quiz/?q='+q_id;
var whole_url = '<iframe style="width: 100%;" src="http://'+domain+'/quiz/?q='+q_id+'&iframe=true" height="500" frameborder="0" scrolling="no"></iframe>';

$('#href_fb').attr({'href':fb_url});
$('#href_tw').attr({'href':tw_url});
$('#href_ln').attr({'href':ln_url});
$('#href_clip').attr({'href':clip_url});
$('#whole_url').val(whole_url);

// cz manifest cache is not possible to use wildcard I tried to put NETWORK though
//quizUsrShow();
//answer_by_q_show();
//tag_show();

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
  setTimeout(function(){
    answer_1(this_seq);
  },1000);
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
  localStorage.current_q = next_q;
  setTimeout(function(){
    location.href = '';
  },1000);
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


var resCo = [];
var resInco = [];
var amt_co = 0;
var amt_answer = 0;






