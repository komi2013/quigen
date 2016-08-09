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
