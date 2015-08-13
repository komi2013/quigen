if(status == 1){
  $('#following1').css({'display': ''});
}else if(status == 2){
  $('#following2').css({'display': ''});
}else{
  $('#following0').css({'display': ''});  
}

var second_1 = Math.round(new Date().getTime() /1000);
$('#right').click(function(){
  if(!u_id){
    alert('はじめにクイズに答えてください');
    return;
  }
  var second_2 = Math.round(new Date().getTime() /1000);
  if(second_2 - second_1 < 2){
    alert('wait 2 seconds');
    return;
  }
  second_1 = Math.round(new Date().getTime() /1000);
  if(status > 0){
    var url_1 = '/followingdel/';
    $('#following0').css({'display': ''});
    $('#following1').css({'display': 'none'});
  }else{
    var url_1 = '/followingadd/';
    $('#following0').css({'display': 'none'});
    $('#following1').css({'display': ''});
  }
  if(localStorage.myphoto){
    var myphoto = localStorage.myphoto;
  }else{
    var myphoto = '';
  }
  var param = {
    csrf : $.cookie('csrf')
    ,receiver : receiver
    ,myphoto : myphoto
  };
  $.post(url_1,param,function(){},"json")
  .always(function(res){
    if(res[0]==1){
    }else{
      if(status < 1){
        $('#following1').css({'display': 'none'});
        $('#following0').css({'display': ''});
      }else{
        $('#following0').css({'display': 'none'});
        $('#following1').css({'display': ''});
      }
      alert('connection error');
    }
  });
  ga('set', 'dimension6','follow');
  ga('send','event','follow',url_1,'none',1);
});

var endTime = Math.round( new Date().getTime() / 1000 );
var addLimit = 20;
var celNum = 0;
var resData = [];
function addCelAnswer(resData){
  while(celNum < addLimit){
    var cellId = resData[celNum][0];
    var cellTxt = resData[celNum][1];
    if(resData[celNum][5] == 1){
      var result = '<img src="/assets/img/icon/circle_big.png" alt="correct" class="icon result">';
    }else{
      var result = '<img src="/assets/img/icon/cross_big.png" alt="incorrect" class="icon result">';
    }
    if(resData[celNum][2]){
      var append = 
      '<tr><td class="td_15_c">'+
      '<a href="/quiz/?q='+cellId+'">'+
      '<img src="'+resData[celNum][2]+'" alt="quiz" class="icon"></a>'+
      '</td><td class="td_68_ct">'+
      '<a href="/quiz/?q='+cellId+'">'+
      '<input type="text" value="'+cellTxt+'" readonly class="input_txt_c"></a>'+
      '</td><td class="td_15_c">'+result+
      '</td></tr>';
    }else{
      var append = 
      '<tr><td colspan="2" class="td_84_ct">'+
      '<a href="/quiz/?q='+cellId+'">'+
      '<input type="text" value="'+cellTxt+'" readonly class="input_txt_c"></a>'+
      '</td><td class="td_15_c">'+result+
      '</td></tr>';
    }
    $('#cel').append(append);
    ++celNum;
    if(!resData[celNum]){
      return;
    }
  }
}

function addCel(resData){
  while(celNum < addLimit){
    var cellTxt = resData[celNum][1];
    var cellQdata = resData[celNum][3];
    if(resData[celNum][2]){ // img is not empty
      var append = 
      '<tr><td class="td_15_c">'+
      '<a href="/quiz/?crypt_q='+cellQdata+'">'+
      '<img src="'+resData[celNum][2]+'" alt="quiz" class="icon"></a>'+
      '</td><td class="td_84_ct">'+
      '<a href="/quiz/?crypt_q='+cellQdata+'">'+
      '<input type="text" value="'+cellTxt+'" readonly class="input_txt_c"></a>'+
      '</td></tr>';
    }else{
      var append = 
      '<tr><td colspan="2" class="td_99_ct">'+
      '<a href="/quiz/?crypt_q='+cellQdata+'">'+
      '<input type="text" value="'+cellTxt+'" readonly class="input_txt_c"></a>'+
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
  var param = {
    endTime : endTime
    ,usr : receiver
    ,list : list
  };
  $.get('/uquestionshow/',param,function(){},"json")
  .always(function(res){
//     resData = id, txt, img
    if(res[0]==1){
      resData = $.merge($.merge([], resData), res[1]);
      endTime = res[1].pop()[4];
      if(first == 1){
        if(list == 'quiz'){
          addCel(resData);  
        }else{
          addCelAnswer(resData);
        }
        
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
        if(list == 'quiz'){
          addCel(resData);  
        }else{
          addCelAnswer(resData);
        }
      }
    }
  });
});
ga('send', 'pageview');