var param = {
  q : 'tag'
};
$.get('/tagshow/',param,function(){},"json")
.always(function(res){
  if(res[0]==1){
    for(var i=0, len=res[1].length; i<len; i++) {
      $('#tag_list').append('<option>#'+res[1][i]+'</option>');
    }
  }
});
if(localStorage.last_tag){
  $('#tag_name').val(localStorage.last_tag);  
}
if(localStorage.quest){
  var quest = JSON.parse(localStorage.quest);
  quest[0] = 1;
  localStorage.quest = JSON.stringify(quest);
}
$('#search').click(function(){
  if( !$('#tag_name').val() ){
    return;
  }
  if( $('#tag_name').val().match(/#/) ){
    localStorage.last_tag = $('#tag_name').val();
    location.href = '/htm/?p=search&tag='+$('#tag_name').val().replace(/#/,'');
  }else{
    location.href = 'http://www.google.com/cse?cx=015373518288618476449%3Akrlgey0pdhk&ie=UTF-8&q='+$('#tag_name').val()+'&sa=Search#gsc.tab=0&gsc.q='+$('#tag_name').val()+'&gsc.page=1';
  }
});

if(localStorage.answer){
  var answer = JSON.parse(localStorage.answer);
}else{
  var answer = [];
}
for (var i = 0, len = arr_answer.length; i < len; i++) {
    for (var ii = 0, lenlen = answer.length; ii < lenlen; ii++) {
    if(answer[ii][0] == arr_answer[i]){
      $('#q_id_'+arr_answer[i]).css("color","purple");
    }
  }
}



if(!localStorage.amt_top){
  answerStep();
  localStorage.amt_top = 1;
}
function answerStep(){
  setTimeout(function(){
    var limit = 0;
    while(limit < 3){
      $('.attention').fadeOut(1000,function(){
        $(this).css("background-color","yellow");
      }).fadeIn(1000);
      ++limit;
    }
  }, 3000);
}
//if(localStorage.quest){
//  var quest = JSON.parse(localStorage.quest);
//  quest[1][1] = '<img src="/assets/img/icon/circle_big.png" class="icon">';
//  localStorage.quest = JSON.stringify(quest);
//}else{
//  var quest = [];
//  quest[0] = ['クイズに答える','<img src="/assets/img/icon/circle_big.png" class="icon">'];
//  quest[1] = ['<a href="/top/">他のクイズを確認</a>','<img src="/assets/img/icon/circle_big.png" class="icon">'];
//  quest[2] = ['<a href="/myanswer/">マイアンサー(復習)を確認</a>','<img src="/assets/img/icon/success_0.png" class="icon">'];
//  quest[3] = ['<a href="myprofile">マイプロファイルを確認</a>','<img src="/assets/img/icon/success_0.png" class="icon">'];
//  localStorage.quest = JSON.stringify(quest);
//}

ga('send', 'pageview');