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
    location.href = '/search/?tag='+$('#tag_name').val().replace(/#/,'');
  }else{
//    location.href = 'http://www.google.com/cse?cx=015373518288618476449%3Axapsve96qx0&ie=UTF-8&q='+$('#tag_name').val()+'&sa=Search#gsc.tab=0&gsc.q='+$('#tag_name').val()+'&gsc.page=1';
    location.href = 'https://www.google.co.jp/webhp?hl=ja#hl=ja&q=site:'+mydomain+'+'+$('#tag_name').val();
  }
});

$('input').keypress(function (e) {
  var key = e.which;
  if(key == 13) {
    $('#search').click();
    return false;  
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
      $('#q_id_'+arr_answer[i]).css("color","#990099");
    }
  }
}
localStorage.removeItem('amt_top');