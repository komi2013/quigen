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
  if(quest[0] != 1){
    quest[0] = 1;
    localStorage.quest = JSON.stringify(quest);
    notify[2] = 'yet';
    notify[3] = 1;
    notify[4] = notify[4]+1;
    if(localStorage.news){
      var news = JSON.parse(localStorage.news);
    }else{
      var news = [];
    }
    news.unshift('<a href="/htm/quest/">'+checked_top+'<img src="/assets/img/icon/star_1.png"></a>');
    localStorage.news = JSON.stringify(news);
    localStorage.notify = JSON.stringify(notify);
  }
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

localStorage.removeItem('amt_top');