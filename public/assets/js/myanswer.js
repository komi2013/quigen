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
    var ticket = JSON.parse(localStorage.ticket);
    ticket[0] = ticket[0] + 12;
    localStorage.ticket = JSON.stringify(ticket);
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
      '<tr><td class="td_15" colspan="15">'+
      '<a href="/quiz/?q='+cellId+'">'+
      '<img src="'+resData[celNum][3]+'" alt="quiz" class="icon"></a>'+
      '</td><td colspan="85" class="td_84">'+
      '<a href="/quiz/?q='+cellId+'">'+result+decodeURIComponent(cellTxt)+
      '</a>'+
      '</td>'+
      '</tr><tr>'+
      '<td colspan="50" class="td_49_t">'+
      '<a href="/htm/offline_quiz/?q='+cellId+'"><img src="/assets/img/icon/no_internet.png" alt="offline" class="icon"></a>'+
      '</td>'+
      '<td colspan="50" class="td_50_t"><img src="/assets/img/icon/trash.png" alt="delete" class="icon" onClick="delAnswer('+cellId+')"></td>'
      '</tr>';
    }else{
      var append = 
      '<tr><td colspan="100" class="td_84">'+
      '<a href="/quiz/?q='+cellId+'">'+result+decodeURIComponent(cellTxt)+
      '</a>'+
      '</td>'+
      '</tr><tr>'+
      '<td colspan="50" class="td_49_t">'+
      '<a href="/htm/offline_quiz/?q='+cellId+'"><img src="/assets/img/icon/no_internet.png" alt="offline" class="icon"></a>'+
      '</td>'+
      '<td colspan="50" class="td_50_t"><img src="/assets/img/icon/trash.png" alt="delete" class="icon" onClick="delAnswer('+cellId+')"></td>'
      '</tr>';
    }
    $('#cel').append(append);    
    ++celNum;
    if(!resData[celNum]){
      return;
    }

  }
}

function delAnswer(cellId) {
  r = confirm('削除します');
  if(r){
    var new_answer = [];
    var ii=0;
    for(var i=0; i<answer.length; i++){
      if(answer[i][0] != cellId){
        new_answer[ii] = answer[i];
        ii++;
      }
    }
    localStorage.answer = JSON.stringify(new_answer);
    location.href = '';
  }  
}
