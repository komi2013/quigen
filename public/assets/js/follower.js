var endNum = 0;
var addLimit = 20;
var celNum = 0;
var resData = [];
function addCel(resData){
  var cellTxt = '';
  var celImg = '';
  while(celNum < addLimit){
    cellId = resData[celNum][0];
    cellTxt = resData[celNum][1];
    if(resData[celNum][2]){
      celImg = resData[celNum][2];
    }else{
      celImg = '/assets/img/icon/guest.png';
    }
    var append = 
    '<tr><td class="td_15_c">'+
    '<a href="/profile/?u='+cellId+'" >'+
    '<img src="'+celImg+'" alt="follower photo" class="icon"></a>'+
    '</td><td class="td_84_ct">'+
    '<a href="/profile/?u='+cellId+'" >'+
    '<input type="text" value="'+cellTxt+'" readonly class="input_txt_c"></a>'+
    '</td></tr>';
    $('#cel').append(append);
    ++celNum;
    if(!resData[celNum]){
      return;
    }
  }
}

function getData(first){
  var param = {
    endNum : endNum,
    receiver : receiver
  };
  $.get('/followershow/',param,function(res){
    if(res[0]==1){
      resData = $.merge($.merge([], resData), res[1]);
      endNum = res[1].pop()[0];
      if(first == 1){
        addCel(resData);
      }
    }else if(res[0]==2){
    }
  }, "json");
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
ga('send', 'pageview');