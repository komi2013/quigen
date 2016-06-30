var next_q = 0;
var prev_q = 0;
var arr_next = [];
var arr_prev =[];
var q_id = localStorage.current_q;

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

var rand_ch = [1,2,3,4];
rand_ch = shuffle(rand_ch);

if(localStorage.offline_q){
  var offline_q = JSON.parse(localStorage.offline_q);
  for(var i = 0; i < offline_q.length; i++){
    if(offline_q[i][7] == q_id){
      var q_txt = offline_q[i][0];
      var ch_0 = offline_q[i][rand_ch[0]];
      var ch_1 = offline_q[i][rand_ch[1]];
      var ch_2 = offline_q[i][rand_ch[2]];
      var ch_3 = offline_q[i][rand_ch[3]];
      var correct = offline_q[i][5];
      var q_img = offline_q[i][6];
      if(i > 0){
        next_q = offline_q[i-1][7];
        arr_next = offline_q[i-1];
      }
      if(offline_q[i+1]){
        prev_q = offline_q[i+1][7];
        arr_prev = offline_q[i+1];
      }
      var comment = offline_q[i][8];
      var quiz_num = offline_q[i][10];
    }
  }
  $('#question').empty().append(q_txt);
  $('#choice_0').empty().append(ch_0);
  $('#choice_1').empty().append(ch_1);
  $('#choice_2').empty().append(ch_2);
  $('#choice_3').empty().append(ch_3);
  $('#comment').empty().append(comment);
  if(quiz_num){
    $('.unread').append('No.'+quiz_num+' ');  
  }
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

var hour_stamp = Math.floor(new Date().getTime() /1000 /60 /60);

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
  var q_img = ($('#photo').attr('src'))? $('#photo').attr('src') : '';
  var myphoto = localStorage.myphoto ? localStorage.myphoto : '';
  var myname = localStorage.myname ? localStorage.myname : '';
  for(var i = 0; i < offline_q.length; i++){
    if(offline_q[i][7] == q_id){
      offline_q[i][9] = $(this_seq).html();
    }
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
  var hour_stamp = Math.floor(new Date().getTime() /1000 /60 /60); 
  var notify = JSON.parse(localStorage.notify);
  notify[1] = hour_stamp+1;
  localStorage.notify = JSON.stringify(notify);
  if(next_q > 0){
    localStorage.current_q = next_q;
    setTimeout(function(){
      location.href = '';
    },1000);
  }
}

add_navi(arr_next);
add_navi(arr_prev);

function add_navi(arr_q) {
  if(!arr_q[0]){
    return;
  }
  var append = '';
  if(arr_q[6]){
    append = 
    '<tr><td colspan="15" class="td_15_t">'+
    '<img src="'+arr_q[6]+'" alt="quiz" class="icon" onClick="goOffline('+arr_q[7]+')">'+
    '</td><td colspan="85" class="td_84_t anchor" onClick="goOffline('+arr_q[7]+')">'
    +decodeURIComponent(arr_q[0].replace(/\+/g,'%20').replace(/&lt;br&gt;/g,'')).substring(0,30)+
    '</td>'+
    '</tr>';
  }else{
    append = 
    '<tr><td colspan="100" class="td_84_t anchor" onClick="goOffline('+arr_q[7]+')">'
    +decodeURIComponent(arr_q[0].replace(/\+/g,'%20').replace(/&lt;br&gt;/g,'')).substring(0,30)+
    '</td>'+
    '</tr>';
  }
  $('#next_prev').append(append);
}

function goOffline(cellId) {
  localStorage.current_q = cellId;
  location.href = '/htm/quiz_offline/ ';
}

var resCo = [];
var resInco = [];
var amt_co = 0;
var amt_answer = 0;

if(!navigator.onLine){
  $('#sns').css({'display':'none'});
}
