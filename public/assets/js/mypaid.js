if(localStorage.point){
  var point = localStorage.point;
}else{
  var point = 0;
}
$('#point').empty().append(point+' pt');

var endNum = 0;
var addLimit = 20;
var celNum = 0;
var resData = [];
function addCel(resData){
  var cellTxt = '';
  while(celNum < addLimit){
    cellId = resData[celNum][0];
    cellTxt = resData[celNum][1];
    var append = 
    '<tr><td class="pack_txt">'+
    '<a href="/pack/?p='+cellId+'">'+
    '<input type="text" value="'+cellTxt+'" readonly class="input_txt"></a>'+
    '</td></tr>';
    $('#cel').append(append);
    ++celNum;
    if(!resData[celNum]){
      return;
    }

  }
}

function getData(first){
  if(localStorage.answer){
    var answer = JSON.parse(localStorage.answer);
  }else{
    var answer = [];
  }
  var past = [];
  for(i = 0; i < answer.length; i++){
    past[i] = answer[i][0];
  }
  var param = {
    past : past,
    endNum : endNum
  };
  $.get('/mypaidshow/',param,function(){},"json")
  .always(function(res){
//     resData = id, txt, img
    if(res[0]==1){
      resData = $.merge($.merge([], resData), res[1]);
      if(first == 1){
        addCel(resData);
      }
      endNum = res[1].pop()[0];
    }else{
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
