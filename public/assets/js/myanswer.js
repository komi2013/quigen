var endNum = 0;
var addLimit = 100;
var celNum = 0;

var offline_q = [];
if(localStorage.offline_q){
  offline_q = JSON.parse(localStorage.offline_q);
}

addCel(offline_q);
//    offline_q.unshift([
//   0   $('#question').html()  
//   1   ,$('#choice_0').html()
//   2   ,$('#choice_1').html()
//   3   ,$('#choice_2').html()
//   4   ,$('#choice_3').html()
//   5   ,correct
//   6   ,$('#photo').attr('src')
//   7   ,q_id
//   8   ,comment_offline
//   9   ,$(this_seq).html()  my answer
//  10   ,quiz_num  my answer
//    ]);
function addCel(res){
  if(!res[0]){
    return;
  }
  while(celNum < addLimit){
    var cellId = res[celNum][7];
    var cellTxt = res[celNum][0];
    if(res[celNum][5] == res[celNum][9]){
      var result = '<img src="/assets/img/icon/circle_big.png" alt="correct" class="icon result" id="img_'+cellId+'">';
    }else{
      var result = '<img src="/assets/img/icon/cross_big.png" alt="incorrect" class="icon result" id="img_'+cellId+'">';
    }
    var quiz_num_txt = '';
    if(res[celNum][10]){
      quiz_num_txt = 'No.'+res[celNum][10]+' '; // only migration time cz localstorage data
    }
    var append = 
    '<tr><td colspan="100" class="td_84" id="position_'+cellId+'">'+
    '<a href="/quiz/?q='+cellId+'">'+result+decodeURIComponent(cellTxt.replace(/\+/g,'%20').replace(/&lt;br&gt;/g,' ')).substring(0,30)+
    '...</a>'+
    '</td>'+
    '</tr><tr>'+
    '<td colspan="50" class="td_49_t">'+
    '<img src="/assets/img/icon/no_internet.png" alt="offline" class="icon" onClick="goOffline('+cellId+')">'+
    '</td>'+
    '<td colspan="50" class="td_50_t"><img src="/assets/img/icon/trash.png" alt="delete" class="icon" onClick="delAnswer('+cellId+')"></td>'
    '</tr>';
    $('#cel').append(append);    
    ++celNum;
    if(!res[celNum]){
      return;
    }
  }
}

function delAnswer(cellId) {
  r = confirm('delete');
  if(r){
    var new_offline_q = [];
    var i2 = 0;
    for(var i=0; i<offline_q.length; i++){
      if(offline_q[i][7] != cellId){
        new_offline_q[i2] = offline_q[i];
        i2++;
      }
    }
    setTimeout(function(){
      localStorage.offline_q = JSON.stringify(new_offline_q);
      location.href = '';
    },1000);
  }
}

function goOffline(cellId) {
  localStorage.current_q = cellId;
  location.href = '/htm/quiz_offline/ ';
}
if(localStorage.quest){
  var quest = JSON.parse(localStorage.quest);
  if(quest[1] != 1){
    quest[1] = 1;
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
    news.unshift('<a href="/htm/quest/">offline is completed<img src="/assets/img/icon/star_1.png"></a>');
    localStorage.news = JSON.stringify(news);
    localStorage.notify = JSON.stringify(notify);
  }
}
$('#position').click(function(){
  location.href = '/htm/myanswer_offline/#position_'+localStorage.current_q;
});
