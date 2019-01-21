var content = new Vue({
  el: '#content',
  data: {
      u_id: 111
      ,myname: localStorage.myname ? localStorage.myname : ''
      ,introduce: ''
      ,follower: 0
      ,following: 0
      ,nice: 0
      ,certify:0
      ,num_ratio:0
      ,answer_by_u:JSON.parse(localStorage.answer_by_u)
      ,num_answer:0
      ,list_rank:[]
      ,list_forum:[]
      ,list_graph:[]
//      ,list_answer:0
//      ,list_msg:0
      ,amt_forum:0
  },
  computed: {
    num_ratio: function () {
      var num_ratio = 0;
      if(localStorage.answer_by_u){
        var answer_by_u = JSON.parse(localStorage.answer_by_u);
        if(answer_by_u[1] > 0){
            num_ratio = Math.round(answer_by_u[0]/answer_by_u[1] * 100);
        }
      }
      return num_ratio;
    }
  }
});

//if(localStorage.answer_by_u){
//  var answer_by_u = JSON.parse(localStorage.answer_by_u);
//  $('#num_answer').empty().append(answer_by_u[1]);
//  if(answer_by_u[1] > 0){
//    $('#num_ratio').empty().append(Math.round(answer_by_u[0]/answer_by_u[1] * 100)+' %');
//  }else{
//    $('#num_ratio').empty().append('0 %');
//  }
//}

$.get('/myprofileshow/',{},function(){},"json")
.always(function(res){
  console.log(res);
//  Vue.set(content.introduce, 0, 2)
  content.introduce = res.introduce;
//  content.follower_url = "/follower/?u="+localStorage.ua_u_id;
//  content.follower = "/follower/?u="+localStorage.ua_u_id;
//  content.following_url = "/following/?u="+localStorage.ua_u_id;
  if(res[0]==1){
  }else if(res[0]==2){
  }
});
if(getVal.warn){
  alert(please_logout);
  location.href = '/myprofile/';
}

if(localStorage.quest){
  var quest = JSON.parse(localStorage.quest);
  if(quest[2] != 1){
    quest[2] = 1;
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
    news.unshift('<a href="/htm/quest/">'+checked_mypage+'<img src="/assets/img/icon/star_1.png"></a>');
    localStorage.news = JSON.stringify(news);
    localStorage.notify = JSON.stringify(notify);
  }
}

if(localStorage.follow){
  var follow = JSON.parse(localStorage.follow);
  content.following = follow.length;
//  $('#num_following').empty().append(follow.length); 
}
if(localStorage.ua_u_id){
  $('#del_cookie').attr('src','/assets/img/icon/power_1.png'); 
}
if(localStorage.login_db){
  $('#del_cookie').attr('src','/assets/img/icon/power_2.png');
}

$('.auth').click(function(){
  r = confirm(login);
  if(r){
    (localStorage.myphoto)? myphoto = localStorage.myphoto : myphoto = '';
    (localStorage.myname)? myname = localStorage.myname : myname = '';
    (localStorage.answer_by_u)? answer_by_u = localStorage.answer_by_u : answer_by_u = [];
    (localStorage.offline_q)? offline_q = localStorage.offline_q : offline_q = [];
    ga('set', 'dimension10',$(this).attr('alt'));
    ga('send','event','auth',$(this).attr('alt'),localStorage.ua_u_id,1);
    location.href = $(this).data('url');
  }
});

var childWindow;
$('#photo').click(function() {
  if(!u_id){
    alert(answer_first);
    return;
  }
  childWindow = window.open("/htm/photo/", "winB");
});
function winCloseB(){
  childWindow.close();
  var param = {
    csrf : csrf
    ,img : localStorage.getItem('img')
  };
  $.post('/photoprofileadd/',param,function(){},"json")
  .always(function(data){
    if(data[0] == 1){
      localStorage.myphoto = data[1];
    }else{
      alert('connection error');
    }
  });
}

$('#generate').click(function(){
  if(!u_id){
    alert(answer_first);
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
  r = confirm(change_profile);
  if(r){
    $('#generate').css({'display': 'none'});  
    $('#success').css({'display': ''});
    var param = {
      csrf : csrf
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

$('input').keypress(function (e) {
  var key = e.which;
  if(key == 13) {
    $('#generate').click();
    return false;  
  }
});

$('#del_cookie').click(function(){
  r = confirm(logout);
  if(r){
    localStorage.clear();
    $.post('/myprofiledel/',{csrf:csrf},function(){},"json")
    .always(function(res){
      if(res[0]==1){
        location.href='';
      }
    });
  }
});

//var rank = ''
//  +'<tr>'
//    +'<td class="td_68_c">'+tag_category+'</td>'
//    +'<td class="td_15"><img src="/assets/img/icon/circle_big.png" class="icon"></td>'
//    +'<td class="td_15"><img src="/assets/img/icon/ranking.png" class="icon"></td>'
//  +'</tr>';
//
$.get('/myanswershow/',{},function(){},"json")
.always(function(res){
  console.log(res);
  if(res[0]==1){
    content.list_rank = res[1];
//    content.list_rank = [
//        ['komatsu',2,3,'komatsu']
//        ,['seijiro',1,4,'seijiro']
//    ];
  }else if(res[0]==2){
  }
});
