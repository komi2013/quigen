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
if (window.matchMedia('(min-width: 711px)').matches) {
  $(window).scroll(function(){
    var scrTop = $(document).scrollTop(); // px
    if(scrTop > 1000){
      $('#drawer').css({'position':'fixed','margin-top':'-50px'});
    }else{
      $('#drawer').css({'position':'absolute','margin-top':'-1px'});
    }
  });
}
if(localStorage.quest_level > 2){
  $('.disp_quest').css({ 'display': ''});
}else{
  $('.disp_quest').css({ 'display': 'none'});
}
