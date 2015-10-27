var drawerIsOpen = false;
$('#menu').click(function(){
  if(drawerIsOpen){
    $('#drawer').css({
      'left': '-100%'
    });
    drawerIsOpen = false;
  }else{
    $('#drawer').css({
      'left': -1
    });
    drawerIsOpen = true;
  }
});
var hour_stamp = Math.floor(new Date().getTime() /1000 /60 /60);
//393009 = 2014-11-01 18:00:00
if(localStorage.last_visit){
  if( (hour_stamp - localStorage.last_visit) > 3 ){
    localStorage.session = localStorage.session*1 + 1;
    if(localStorage.session > 9 && localStorage.session < 100){
      var session_amt= localStorage.session / 10;
      session_amt = Math.floor(session_amt) * 10;
    }else if(localStorage.session > 100){
      var session_amt = 100;
    }else{
      var session_amt = localStorage.session;
    }
    ga('set', 'dimension18', session_amt);
    localStorage.last_visit = hour_stamp;
    localStorage.session_answer = 0;
  }
}else{
  localStorage.last_visit = hour_stamp;
  localStorage.session = 1;
  localStorage.session_answer = 0;
  ga('set', 'dimension18', localStorage.session);
}

$(window).load(function(){
  $(".ad_frame").contents().bind("click",function(){
    var ua_u_id = 1;
    if(localStorage.ua_u_id){
      ua_u_id = localStorage.ua_u_id;
    }
    ga('send','event','ad',ua_u_id,$(this)[0].URL.split('af=')[1],1);
  });
});

if(localStorage.quest_level > 2){
  $('.disp_quest').css({ 'display': ''});
}else{
  $('.disp_quest').css({ 'display': 'none'});
}
