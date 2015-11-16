if(localStorage.last_tag){
  $('#tag_name').val( localStorage.last_tag );
}
$('#search').click(function(){
  if( !$('#tag_name').val() ){
    return;
  }
  localStorage.last_tag = $('#tag_name').val();
  location.href = '';    
});

function highlighting(highlight,sc_height,drawer_open){
  scrollTo(0,sc_height);
  if (matchMedia('only screen and (max-width : 710px)').matches && drawer_open) {
    $('#drawer').css({
      'left': -1
    });
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

if(localStorage.quest){
  var quest = JSON.parse(localStorage.quest);
  if(quest[3] != 1){
    quest[3] = 1;
    localStorage.quest = JSON.stringify(quest);
    setTimeout(function(){
      highlighting('#page_quest',200,true);
    },3000);
  }
}

var endTime = Math.round( new Date().getTime() / 1000 );
var addLimit = 20;
var celNum = 0;
var resData = [];

function addCel(resData){
  while(celNum < addLimit){
    var append = 
    '<tr><td class="td_15_t">'+
    '<a href="/profile/?u='+resData[celNum][0]+'">'+
    '<img src="'+resData[celNum][2]+'" alt="usr" class="icon" '+resData[celNum][4]+'></a>'+
    '</td><td class="td_50_t">'+
    '<a href="/profile/?u='+resData[celNum][0]+'">'+resData[celNum][1]+'</a>'+
    '</td><td class="td_15_t">'+resData[celNum][3]+
    '</td><td class="td_15_t">'+'<img src="/assets/img/icon/circle_big.png" alt="correct" class="icon">'+
    '</td></tr>';

    $('#cel').append(append);
    ++celNum;
    if(!resData[celNum]){
      return;
    }
  }
}
var last_tag = (localStorage.last_tag)? localStorage.last_tag : '';
if(last_tag){
  function getData(first){
    var param = {
      endTime : endTime
      ,tag : last_tag
    };
    $.get('/rankshow/',param,function(){},"json")
    .always(function(res){
  //     resData = id, txt, img, crypt, endtime
      if(res[0]==1){
        resData = $.merge($.merge([], resData), res[1]);
        endTime = res[1].pop()[4];
        if(first == 1){
          addCel(resData);
        }
      }else if(res[0]==2){
      }
    });
  }
}

var dataLimit = 80;
$(function(){
  getData(1);
});
