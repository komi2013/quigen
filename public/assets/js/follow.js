var endTime = Math.round( new Date().getTime() / 1000 );
var addLimit = 20;
var celNum = 0;
var resData = [];
function addCel(resData){
  while(celNum < addLimit){
    var cellTxt = resData[celNum][1];
    var cellQdata = resData[celNum][3];
    if(resData[celNum][2]){ // img is not empty
      var append = 
      '<tr><td class="td_15_t">'+
      '<a href="/quiz/?q='+resData[celNum][0]+'">'+
      '<img src="'+resData[celNum][2]+'" alt="quiz" class="icon"></a>'+
      '</td><td class="td_84_t">'+
      '<a href="/quiz/?q='+resData[celNum][0]+'">'+cellTxt+'</a>'+
      '</td></tr>';
    }else{
      var append = 
      '<tr><td colspan="2" class="td_99_tt">'+
      '<a href="/quiz/?q='+resData[celNum][0]+'">'+cellTxt+'</a>'+
      '</td></tr>';
    }
    $('#cel').append(append);
    ++celNum;
    if(!resData[celNum]){
      return;
    }
  }
}

function getData(first){
  if(localStorage.follow){
    var follow = JSON.parse(localStorage.follow);
  }else{
    return;
  }
  var param = {
    endTime : endTime,
    follow : follow
  };
  $.get('/followshow/',param,function(){},"json")
  .always(function(res){
//     resData = id, txt, img
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

var dataLimit = 80;
$(function(){
  getData(1);
  var detect = 300;
  $(window).scroll(function(){
    var scrTop = $(document).scrollTop();
    if(scrTop > detect){
      detect = detect + 300;
      addLimit = addLimit + 20;
      if(addLimit > dataLimit){
        dataLimit = dataLimit + 80;
        getData();
      }
      if(resData[celNum]){
        addCel(resData);
      }
    }
  });
});
