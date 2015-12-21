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
    location.href = '/search/?tag='+$('#tag_name').val().replace(/#/,'');
  }else{
    location.href = 'http://www.google.com/cse?cx=015373518288618476449%3Akrlgey0pdhk&ie=UTF-8&q='+$('#tag_name').val()+'&sa=Search#gsc.tab=0&gsc.q='+$('#tag_name').val()+'&gsc.page=1';
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

var detect = 9600; //px
$(window).scroll(function(){
  var scrTop = $(document).scrollTop(); // px
  if(scrTop > detect && nextPage > 0){
    detect = detect + 9600;
    $.ajax({
      type: 'GET',
      url: '/search/',
      dataType: 'html',
      data: {
        tag : tag
        ,page: nextPage
      },
      success: function(data) {
        $('#cel').append($(data).find('#cel tr'));
        nextPage = $(data).find('#nextPage').html();
      }
    });      
  }
});

//
//var addLimit = 100;
//var celNum = 0;
//var resData = [];
//function addCel(resData){
//  while(celNum < addLimit){
//    var read = '';
//    for (var i = 0, len = answer.length; i < len; i++) {
//      if(answer[i][0] == resData[celNum][0]){
//        read = 'style="color:#990099;"';
//      }
//    }
//    var cellTxt = resData[celNum][1];
//    var cellQdata = resData[celNum][3];
//    if(resData[celNum][2]){ // img is not empty
//      var append = 
//      '<tr><td class="td_15_t">'+
//      '<a href="/quiz/?crypt_q='+cellQdata+'" '+read+'>'+
//      '<img src="'+resData[celNum][2]+'" alt="quiz" class="icon"></a>'+
//      '</td><td class="td_84_t">'+
//      '<a href="/quiz/?crypt_q='+cellQdata+'" '+read+'>'+cellTxt+'</a>'+
//      '</td></tr>';
//    }else{
//      var append = 
//      '<tr><td colspan="2" class="td_99_t">'+
//      '<a href="/quiz/?crypt_q='+cellQdata+'" '+read+'>'+cellTxt+'</a>'+
//      '</td></tr>';
//    }
//    $('#cel').append(append);
//    ++celNum;
//    if(!resData[celNum]){
//      return;
//    }
//  }
//}
//
//function getData(){
//  if(localStorage.answer){
//    var answer = JSON.parse(localStorage.answer);
//  }else{
//    var answer = [];
//  }
//  var past = [];
//  for(i = 0; i < answer.length; i++){
//    past[i] = answer[i][0];
//  }
//  var param = {
//    tag : tag,
//    endTime : endTime
//  };
//  $.get('/searchshow/',param,function(){},"json")
//  .always(function(res){
////     resData = id, txt, img
//    if(res[0]==1){
//      resData = $.merge($.merge([], resData), res[1]);
//      endTime = res[1].pop()[4];
//      //$('#center').empty().append('タグ検索('+res[2]+')');
//    }else{
//    }
//  });
//}
//
//var detect = 9600; //px
//$(window).scroll(function(){
//  var scrTop = $(document).scrollTop(); // px
//  if(scrTop > detect){
//    detect = detect + 4800;
//    addLimit = addLimit + 100;
//    getData();
//    if(resData[celNum]){
//      addCel(resData);
//    }
//  }
//});

