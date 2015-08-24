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
$('#search').click(function(){
  if( !$('#tag_name').val() ){
    return;
  }
  
  if( $('#tag_name').val().match(/#/) ){
    localStorage.last_tag = $('#tag_name').val();
    location.href = '/htm/search/?tag='+$('#tag_name').val().replace(/#/,'');
  }else{
    location.href = 'http://www.google.com/cse?cx=015373518288618476449%3Akrlgey0pdhk&ie=UTF-8&q='+$('#tag_name').val()+'&sa=Search#gsc.tab=0&gsc.q='+$('#tag_name').val()+'&gsc.page=1';
  }
});
if(localStorage.answer){
  var answer = JSON.parse(localStorage.answer);
}else{
  var answer = [];
}

var endTime = Math.round( new Date().getTime() / 1000 );
endTime = endTime + 86400 * 20;
var addLimit = 20;
var celNum = 0;
var resData = [];
function addCel(resData){
  while(celNum < addLimit){
    var read = 'input_txt_c';
    for (var i = 0, len = answer.length; i < len; i++) {
      if(answer[i][0] == resData[celNum][0]){
        read = 'input_txt_read';
      }
    }
    var cellTxt = resData[celNum][1];
    var cellQdata = resData[celNum][3];
    if(resData[celNum][2]){ // img is not empty
      var append = 
      '<tr><td class="td_15_c">'+
      '<a href="/quiz/?crypt_q='+cellQdata+'">'+
      '<img src="'+resData[celNum][2]+'" alt="quiz" class="icon"></a>'+
      '</td><td class="td_84_ct">'+
      '<a href="/quiz/?crypt_q='+cellQdata+'">'+
      '<input type="text" value="'+cellTxt+'" readonly class="'+read+'"></a>'+
      '</td></tr>';
    }else{
      var append = 
      '<tr><td colspan="2" class="td_99_ct">'+
      '<a href="/quiz/?crypt_q='+cellQdata+'">'+
      '<input type="text" value="'+cellTxt+'" readonly class="'+read+'"></a>'+
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
    tag : tag,
    endTime : endTime
  };
  $.get('/searchshow/',param,function(){},"json")
  .always(function(res){
//     resData = id, txt, img
    if(res[0]==1){
      resData = $.merge($.merge([], resData), res[1]);
      if(first == 1){
        addCel(resData);
      }
      endTime = res[1].pop()[4];
      $('#center').empty().append('タグ検索('+res[2]+')');
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
if(typeof ga == "function"){
  ga('send', 'pageview');
}
