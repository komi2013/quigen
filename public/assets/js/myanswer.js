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
  if(quest[1] != 1){
    quest[1] = 1;
    localStorage.quest = JSON.stringify(quest);
    setTimeout(function(){
      highlighting('#page_quest',200,true);
    },3000);
  }
}
if(localStorage.answer_by_u){
  var answer_by_u = JSON.parse(localStorage.answer_by_u);
  $('#num_answer').empty().append(answer_by_u[1]);
  if(answer_by_u[1] > 0){
    $('#num_ratio').empty().append(Math.round(answer_by_u[0]/answer_by_u[1] * 100)+' %');
  }else{
    $('#num_ratio').empty().append('0 %');
  }
}
var endNum = 0;
var addLimit = 100;
var celNum = 0;
if(localStorage.answer){
  var answer = JSON.parse(localStorage.answer);
}else{
  var answer = [];
}

addCel(answer);
function addCel(resData){
  while(celNum < addLimit){
    var cellId = resData[celNum][0];
    var cellTxt = resData[celNum][2];
    if(resData[celNum][1] == resData[celNum][4]){
      var result = '<img src="/assets/img/icon/circle_big.png" alt="correct" class="icon result" id="img_'+cellId+'">';
    }else{
      var result = '<img src="/assets/img/icon/cross_big.png" alt="incorrect" class="icon result" id="img_'+cellId+'">';
    }
    if(resData[celNum][3]){
      var append = 
      '<tr><td class="td_15_c">'+
      '<a href="/quiz/?q='+cellId+'">'+
      '<img src="'+resData[celNum][3]+'" alt="quiz" class="icon"></a>'+
      '</td><td class="td_68_ct">'+
      '<a href="/quiz/?q='+cellId+'">'+
      '<input type="text" value="'+decodeURIComponent(cellTxt)+'" readonly class="input_txt_c"></a>'+
      '</td><td class="td_15_c chk" onClick="checkClick('+cellId+')">'+
      '<input type="checkbox" name="quiz_id" class="icon" value="'+cellId+'" id="chk_'+cellId+'" style="display:none;">'+result+
      '</td></tr>';
    }else{
      var append = 
      '<tr><td colspan="2" class="td_84_ct">'+
      '<a href="/quiz/?q='+cellId+'">'+
      '<input type="text" value="'+decodeURIComponent(cellTxt)+'" readonly class="input_txt_c"></a>'+
      '</td><td class="td_15_c chk" onClick="checkClick('+cellId+')">'+
      '<input type="checkbox" name="quiz_id" class="icon" value="'+cellId+'" id="chk_'+cellId+'" style="display:none;">'+result+
      '</td></tr>';
    }
    $('#cel').append(append);
    ++celNum;
    if(!resData[celNum]){
      return;
    }

  }
}

function checkClick(cellId){
  //console.log($(this));
  var check_empty = 1;
  
  $('#delete').css({'display': ''});
  $('#img_'+cellId).css({'display': 'none'});
  $('#chk_'+cellId).css({'display': ''});
  $('#chk_'+cellId).attr({'checked': true});
  
  $('[name="quiz_id"]:checked').each(function(){
    check_empty = 0;
  });
  if(check_empty == 1){
    $('#delete').css({'display': 'none'});
  }
}

$('#delete').click(function(){
  r = confirm('削除します');
  if(r){
    var quiz_id=[];
    var new_answer = []; 
    $('[name="quiz_id"]:checked').each(function(){
      var i = 0; var ii = 0;
      while(ii < answer.length){
        if(answer[ii][0] != $(this).val()){
          new_answer[i] = answer[ii];
          i++;
        }
        ii++;
      }  
    });
    localStorage.answer = JSON.stringify(new_answer);
    location.href = '';
  }
});
//if(localStorage.quest){
//  var quest = JSON.parse(localStorage.quest);
//  quest[2][1] = '<img src="/assets/img/icon/circle_big.png" class="icon">';
//  localStorage.quest = JSON.stringify(quest);
//}else{
//  var quest = [];
//  quest[0][0] = 'クイズに答える';
//  quest[0][1] = '<img src="/assets/img/icon/circle_big.png" class="icon">';
//  quest[1][0] = '<a href="/top/">他のクイズを確認</a>';
//  quest[1][1] = '<img src="/assets/img/icon/success_0.png" class="icon">';
//  quest[2][0] = '<a href="/myanswer/">マイアンサー(復習)を確認</a>';
//  quest[2][1] = '<img src="/assets/img/icon/circle_big.png" class="icon">';
//  quest[3][0] = '<a href="myprofile">マイプロファイルを確認</a>';
//  quest[3][1] = '<img src="/assets/img/icon/success_0.png" class="icon">';
//  localStorage.quest = JSON.stringify(quest);
//}

ga('send', 'pageview');