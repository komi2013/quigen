(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

if($.cookie('ua_u_id')){
  localStorage.ua_u_id = $.cookie('ua_u_id');
  $.cookie('ua_u_id','',{expires:-1,path:'/'});  
}
if(localStorage.ua_u_id){
  ga('create',ua,'auto',{'userId':'u_'+localStorage.ua_u_id,'allowLinker': true});
  ga('set','dimension2',localStorage.ua_u_id);
}else{
  ga('create',ua,'auto',{'allowLinker': true});
}

if(!$.cookie('ab_test')){
  $.cookie('ab_test',parseInt(Math.random()*10),{expires:730,path:'/'}); 
}
ga('set', 'dimension4', 'ab_'+$.cookie('ab_test'));

ga('require', 'displayfeatures');
ga('require', 'linker');
ga('linker:autoLink', ['quizgenerator.hatenablog.com']);

var getUrlVars = function(){
  var vars = {}; 
  var param = location.search.substring(1).split('&');
  for(var i = 0; i < param.length; i++) {
    var keySearch = param[i].search(/=/);
    var key = '';
    if(keySearch != -1) key = param[i].slice(0, keySearch);
    var val = param[i].slice(param[i].indexOf('=', 0) + 1);
    if(key != '') vars[key] = decodeURI(val);
  }
  return vars; 
}
var getVal = getUrlVars();

if(getVal.cpn){
  ga('set', 'dimension5', getVal.cpn);  
}

function highlighting(highlight,sc_height,drawer_open){
  scrollTo(0,sc_height);
  if (matchMedia('only screen and (max-width : 710px)').matches && drawer_open) {
    $('#drawer').css({
      'left': -1
    });
    if(still_closed){
      $('#ad_menu').empty().append(ad_menu_iframe);
      still_closed = false;
    }
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
function decimal_hexadecimal(res){
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

/*
1 = u_answer_amt 1,2,3...10,20,30
2 = ua_u_id  99,101 
3 = generate_amt 1,2,3...10,20,30
4 = ab_test 0~10
5 = campaign_code 1~999**
6 = follow_amt 1,2,3...10,20,30
7 = profile_edited
8 = ad a8net,nend 
9 = share facebook,twitter,,
10 = authed facebook,twitter,,
11 = contact contacted
12 = quiz owner
13 = tag
14 = comment
15 = report

*/
