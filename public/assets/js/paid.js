$('#search').click(function(){
  if( $('#tag_name').val().match(/#/) ){
    location.href = '/paid/?tag='+$('#tag_name').val().replace(/#/,'');
  }
});

if(localStorage.point){
  var point = localStorage.point;
}else{
  var point = 0;
}
if($.cookie('add_point')){
  localStorage.point = point = (point*1 + $.cookie('add_point')*1);
  $.cookie('add_point','',{expires:-1,path:'/'});
}
$('#point').empty().append(point+' pt');
ga('send', 'pageview');
             
