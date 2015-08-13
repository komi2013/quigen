$('#generate').click(function() {
  if(!u_id){
    alert('はじめにクイズに答えてください');
    return;
  }
  var validate = 1;
  if($('#contact').val()==''){
    $('#contact').css({'border-color':'red'});
    validate=2;
  }
  if(validate==2){
    return;
  }
  var param = {
    csrf : $.cookie('csrf')
    ,contact : $('#contact').val()
  };
  $.post('/contactadd/',param,function(){},"json")
  .always(function(res){
    if(res[0]==1){
      $('#generate').css({'display': 'none'});  
      $('#success').css({'display': ''});
    }else{
     console.log(res);
     alert('connection error');
    }
  });
  ga('set', 'dimension11','contacted');
  ga('send','event','contact','upload',$('#contact').val(),1);
});
ga('send', 'pageview');
