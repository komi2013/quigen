if(getVal.warn){
  alert(please_logout);
  location.href = '/myprofile/';
}

var content = new Vue({
  el: '#content',
  data: {
      u_id: 0
      ,myname: localStorage.myname ? localStorage.myname : ''
      ,introduce: ''
      ,follower: 0
      ,following: 0
      ,nice: 0
      ,certify:0
      ,answer_by_u:
localStorage.answer_by_u ? JSON.parse(localStorage.answer_by_u): []
      ,list_rank:[]
      ,list_forum:[]
      ,list_graph:[]
      ,max:0
      ,amt_forum:0
      ,list:'graph'
      ,provider:0
  },
  computed: {

  }
});


$.get('/myprofileshow/',{},function(){},"json")
.always(function(res){
  console.log(content.list_forum);
  content.u_id = res.usr_id;
  content.myname = res.myname;
  content.introduce = res.introduce;
  content.follower = res.follower;
  content.following = res.following;
  content.nice = res.nice;
  content.certify = res.certify;
  content.list_forum = res.list_forum;
  content.list_graph = res.list_graph;
  content.max = res.max;
  content.amt_forum = res.amt_forum;
  content.provider = res.provider;
//  content.follower_url = "/follower/?u="+localStorage.ua_u_id;
//  content.follower = "/follower/?u="+localStorage.ua_u_id;
//  content.following_url = "/following/?u="+localStorage.ua_u_id;
  if(res[0]==1){
  }else if(res[0]==2){
  }
});

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
  if(!localStorage.login){
    alert(please_login);
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
  if(!localStorage.login){
    alert(please_login);
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

$.get('/myanswershow/',{},function(){},"json")
.always(function(res){
  if(res[0]==1){
    content.list_rank = res[1];
  }else if(res[0]==2){
  }
});
