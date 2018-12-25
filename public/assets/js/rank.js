if(localStorage.last_tag){
  $('#tag_name').val( localStorage.last_tag );
}
$('#tag_name').change(function () {
  if( !$('#tag_name').val() || $('#tag_name').val() == localStorage.last_tag){
    return;
  }
  localStorage.last_tag = $('#tag_name').val();
  location.href = '';    
}).change();

if(localStorage.quest){
  var quest = JSON.parse(localStorage.quest);
  if(quest[3] != 1){
    quest[3] = 1;
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
    news.unshift('<a href="/htm/quest/">'+checked_rank+'<img src="/assets/img/icon/star_1.png"></a>');
    localStorage.news = JSON.stringify(news);
    localStorage.notify = JSON.stringify(notify);
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
