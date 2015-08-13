if(localStorage.point){
  var point = localStorage.point;
}else{
  var point = 0;
}
$('#point').empty().append(point+' pt');
var current_point = point;
var fee =$('#fee').text();

$('#generate').click(function(){
  if(!u_id){
    alert('はじめにクイズに答えてください');
    return;
  }
  var unit = 0;
  $('#unit option:selected').each(function(){
    unit = $(this).text();
  });
  var validate = 1;
  if(unit != 2 && unit != 4 && unit != 6 && unit != 8 && unit != 10){
    validate=2;
  }
  if((current_point - unit * 10000) < 0){
    $('#unit').css({'border-color':'red'});
    validate=2;
  }
  if($('#bank_info').val()==''){
    $('#bank_info').css({'border-color':'red'});
    validate=2;
  }
  if($('#email').val()==''){
    $('#email').css({'border-color':'red'});
    validate=2;
  }
  if(validate===2){
    return;
  }
  $('#generate').css({'display': 'none'});
  $('#success').css({'display': ''});  
  var param = {
    csrf : $.cookie('csrf')
    ,contact : unit+',,'+$('#email').val()+',,'+$('#bank_info').val()
  };
  $.post('/contactadd/',param,function(){},"json")
  .always(function(res){
    if(res[0]==1){
    }else{
      $('#success').css({'display': 'none'});  
      $('#generate').css({'display': ''});
      alert('connection error');
    }
  });
});

$('#generate_send').click(function(){
  if(!u_id){
    alert('はじめにクイズに答えてください');
    return;
  }
  var validate = 1;
  if( !$('input[name=buy_point]:checked').val() ){
    $('input[name=buy_point]').css({'border-color':'red'});
    validate=2;
  }
  if($('#sender').val()==''){
    $('#sender').css({'border-color':'red'});
    validate=2;
  }
  if(validate===2){
    return;
  }
  $('#generate_send').css({'display': 'none'});
  $('#success').css({'display': ''});  
  var param = {
    csrf : $.cookie('csrf')
    ,contact : $('input[name=buy_point]:checked').val()+'pt, bank name:'+$('#sender').val()
  };
  $.post('/contactadd/',param,function(){},"json")
  .always(function(res){
    if(res[0]==1){
      $('#after_post').empty().append('ありがとうございます。3日以内に<a href="/htm/?p=news">お知らせを送ります。</a>');
    }else{
      $('#success').css({'display': 'none'});  
      $('#generate').css({'display': ''});
      alert('connection error');
    }
  });
});

$('#unit').change(function(){
  
  var unit = 0;
  $('#unit option:selected').each(function(){
    unit = $(this).text();
  });
  var point = current_point - unit * 10000; 
  $('#current_point').empty().append(point);
  var money = unit * 10000 / 2 - fee;
  $('#money').empty().append(money);
}).change();



ga('send', 'pageview');
