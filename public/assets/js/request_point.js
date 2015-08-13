
if(localStorage.point){
  var point = localStorage.point;
}else{
  var point = 0;
}
// if($.cookie('add_point')){
//   localStorage.point = point = (point*1 + $.cookie('add_point')*1);
//   $.cookie('add_point','',{expires:-1,path:'/'});
// }
$('#point').empty().append(point+' pt');

$('#buy_point').click(function(){
  if(!localStorage.point || localStorage.point < 200){
    alert('ポイントが足りません');
    return;
  }
  r = confirm('このクイズを購入します');
  if(r){
    var param = {
      csrf : $.cookie('csrf')
      ,pack_id : $('#buy_point').data('pack')
    };
    $.post('/packbuy/',param,function(){},"json")
    .always(function(res){
      if(res[0]==1){
        localStorage.point = res[1];
      }else if(res[0]==3){
        localStorage.point = res[1];
      }
      location.href='';
    });
    ga('set','dimension17','buy_pack');  
    ga('send','event','buy_pack','none',$('#buy_point').data('pack'),1);  
    
  }
});
$('input[name="buy_point"]:radio').each(function(i){
  $(this).attr('checked',false)
});
$('input[name="buy_point"]:radio').change(function(){
  $('input[name="yen"]').attr('value',$(this).val());
});
var dg = new PAYPAL.apps.DGFlow(
{
  trigger: 'paypal_submit',
  expType: 'instant'
   //PayPal will decide the experience type for the buyer based on his/her 'Remember me on your computer' option.
});
ga('send','pageview','/request_point/');

             
