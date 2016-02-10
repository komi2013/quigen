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

var u_id = localStorage.ua_u_id;
var q_txt = '';
var fb_url   = 'http://www.facebook.com/sharer.php?u=http://'+domain+'/profile/?u='+u_id+'%26cpn=share_fb';
var tw_url   = 'https://twitter.com/intent/tweet?url=http://'+domain+'/profile/?u='+u_id+'%26cpn=share_tw&text='+q_txt+'+@quigen2015';
var ln_url   = 'line://msg/text/?'+q_txt+'%0D%0Ahttp://'+domain+'/profile/?u='+u_id+'%26cpn=share_ln';
var clip_url = 'http://'+domain+'/profile/?u='+u_id;

$('#href_fb').attr({'href':fb_url});
$('#href_tw').attr({'href':tw_url});
$('#href_ln').attr({'href':ln_url});
$('#href_clip').attr({'href':clip_url});

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
    var append = 
    '<tr><td colspan="100" class="td_84">'+
    '<a href="/quiz/?q='+cellId+'">'+result+decodeURIComponent(cellTxt.replace(/\+/g,'%20')).substring(0,30)+
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

function goOffline(cellId) {
  localStorage.current_q = cellId;
  location.href = '/htm/offline_quiz/ ';
}

var rank = ''
  +'<tr>'
    +'<td class="td_68_c"><a href="/category/">タグカテゴリ</a></td>'
    +'<td class="td_15"><img src="/assets/img/icon/circle_big.png" class="icon"></td>'
    +'<td class="td_15"><img src="/assets/img/icon/ranking.png" class="icon"></td>'
  +'</tr>';

$.get('/myanswershow/',{},function(){},"json")
.always(function(res){
  if(res[0]==1){
    for (var i=0; i<res[1].length; i++){
      rank = rank+''
        +'<tr>'
          +'<td class="td_68_c"><a href="/search/?tag='+decodeURIComponent(res[1][i][0])+'">'+decodeURIComponent(res[1][i][0])+'</a></td>'
          +'<td class="td_15">'+res[1][i][1]+'</td>'
          +'<td class="td_15">'+res[1][i][2]+'</td>'
        +'</tr>';
    }
    $('#rank').append(rank);
  }else if(res[0]==2){
  }
});