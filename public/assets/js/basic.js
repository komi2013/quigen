var drawerIsOpen = false;
$('#menu').click(function(){
  if(drawerIsOpen){
    $('#drawer').css({'left':'-100%'});
    drawerIsOpen = false;
  }else{
    $('#drawer').css({'left': '-1px','top':$(window).scrollTop()+51+'px'});
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
var nowPosition = 0;
$(window).scroll(function(){
  var scrTop = $(document).scrollTop(); // px
  if (window.matchMedia('(min-width: 711px)').matches) {
    if(scrTop > 1000){
      $('#drawer').css({'position':'fixed','margin-top':'-49px'});
    }else{
      $('#drawer').css({'position':'absolute','margin-top':'-1px'});
    }
  }else{ //sp
    diffPosition = nowPosition - $(window).scrollTop();
    nowPosition = $(window).scrollTop();
    if(scrTop < 4000){
      $('#drawer').css({'position':'absolute','top':'51px'});
    }else if(diffPosition > 200){
      $('#drawer').css({'top':$(window).scrollTop()+51+'px'});
    }
    if(diffPosition < 0 || nowPosition < 4000){ //down scroll
      $('#header').css({'position':'static'});
    }else{ //up scroll
      $('#header').css({'position':'fixed','z-index':'10'});
    }
  }
});

if(localStorage.quest_level > 2){
  $('.disp_quest').css({ 'display': ''});
}else{
  $('.disp_quest').css({ 'display': 'none'});
}

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
  eto[3] = '#'+left+left+middle+middle+right+right;
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

myphoto = '';
myname = '';
mybgcolor = '';
if(localStorage.myphoto){
  myphoto = localStorage.myphoto;
  myname = localStorage.myname;
}else if(localStorage.ua_u_id){
  var eto = get_eto(localStorage.ua_u_id);
  myphoto = eto[2];
  myname = eto[1];
  mybgcolor = eto[3];
}
if(myphoto){
  $('#page_myimg').attr('src',myphoto); 
}
if(mybgcolor){
  $('#page_myimg').css({
    'background-color':mybgcolor
    ,'opacity':'0.7'
  });
}
var rand_ad = parseInt(Math.random()*10);
var ad_ga = 'none';
var ad_right_ga = 'none';
if(window.matchMedia('(min-width: 711px)').matches){
  if(rand_ad < 11){
    var ad_menu_iframe = '<iframe src="/htm/ad_menu/?af=adsense_pc_menu" width="300" height="250" frameborder="0" scrolling="no" class="ad_frame"></iframe>';
    var ad_menu_ga = 'adsense_pc_menu';
  }else if(rand_ad < 11){
    var ad_menu_iframe = '<iframe src="/htm/ad_menu/?af=kauli_pc_menu" width="300" height="250" frameborder="0" scrolling="no" class="ad_frame"></iframe>';
    var ad_menu_ga = 'kauli_pc_menu';
  }else if(rand_ad < 11){
    var ad_menu_iframe = '<iframe src="/htm/ad_menu/?af=imobile_pc_menu" width="300" height="250" frameborder="0" scrolling="no" class="ad_frame"></iframe>';
    var ad_menu_ga = 'imobile_pc_menu';
  }

  if(rand_ad < 11){
    var ad_right_iframe = '<iframe src="/htm/ad_right/?af=adsense_pc_right" width="160" height="600" frameborder="0" scrolling="no" class="ad_frame_right"></iframe>';
    var ad_right_ga = 'adsense_pc_right';
  }else if(rand_ad < 11){
    var ad_right_iframe = '<iframe src="/htm/ad_right/?af=kauli_pc_right" width="160" height="600" frameborder="0" scrolling="no" class="ad_frame_right"></iframe>';
    var ad_right_ga = 'kauli_pc_right';
  }else if(rand_ad < 11){
    var ad_right_iframe = '<iframe src="/htm/ad_right/?af=imobile_pc_right" width="160" height="600" frameborder="0" scrolling="no" class="ad_frame_right"></iframe>';
    var ad_right_ga = 'imobile_pc_right';
  }

}else{
  if(rand_ad < 11){
    var ad_menu_iframe = '<iframe src="/htm/ad_menu/?af=adsense_sp_menu" width="300" height="250" frameborder="0" scrolling="no" class="ad_frame"></iframe>';
    var ad_menu_ga = 'adsense_sp_menu';
  }else if(rand_ad < 11){
    var ad_menu_iframe = '<iframe src="/htm/ad_menu/?af=nend_sp_menu" width="300" height="250" frameborder="0" scrolling="no" class="ad_frame"></iframe>';
    var ad_menu_ga = 'nend_sp_menu';
  }else if(rand_ad < 11){
    var ad_menu_iframe = '<iframe src="/htm/ad_menu/?af=kauli_sp_menu" width="300" height="250" frameborder="0" scrolling="no" class="ad_frame"></iframe>';
    var ad_menu_ga = 'kauli_sp_menu';
  }else if(rand_ad < 11){
    var ad_menu_iframe = '<iframe src="/htm/ad_menu/?af=imobile_sp_menu" width="300" height="250" frameborder="0" scrolling="no" class="ad_frame"></iframe>';
    var ad_menu_ga = 'imobile_sp_menu';
  }
  
  if(rand_ad < 11){
    var ad_iframe = '<iframe src="/htm/ad/?af=adsense_sp" width="320" height="50" frameborder="0" scrolling="no" data-af="adsense_sp" class="ad_frame"></iframe>';
    var ad_ga = 'adsense_sp';
  }else if(rand_ad < 11){
    var ad_iframe = '<iframe src="/htm/ad/?af=nend_sp" width="320" height="50" frameborder="0" scrolling="no" data-af="adsense_sp" class="ad_frame"></iframe>';
    var ad_ga = 'nend_sp';
  }

}

ga('set', 'dimension16', ad_ga+','+ad_menu_ga+','+ad_right_ga);


setTimeout(function(){
  if(window.matchMedia('(min-width: 711px)').matches){
    setTimeout(function(){
      $('#ad_menu').empty().append(ad_menu_iframe);
    },6000);
    $('#ad_right').empty().append(ad_right_iframe);
  }else{
    setTimeout(function(){
      $('#ad_menu').empty().append(ad_menu_iframe);
    },6000);
    $('#ad').empty().append(ad_iframe);
  }
},3000);
//  $('.ad_frame').click(function(){
//
//  });

