if(localStorage.word_arr_q){
  var word_arr_q = JSON.parse(localStorage.word_arr_q);
  for(i = 0; i < 4; i++){
    if( word_arr_q[i] ){
      $('#q_'+i).val(word_arr_q[i]);
    }
  }
}
if(localStorage.word_arr_a){
  var word_arr_a = JSON.parse(localStorage.word_arr_a);
  for(i = 0; i < 4; i++){
    if( word_arr_a[i] ){
      $('#a_'+i).val(word_arr_a[i]);
    }
  }
}

$('#generate').click(function(){
  if(!u_id){
    alert('はじめにクイズに答えてください');
    return;
  }
  var validate = 1;
  var arr_q = [];
  var arr_a = [];
  for(i = 0; i < 4; i++){
    if($('#q_'+i).val()==''){
      $('#q_'+i).css({'border-color':'red'});
      validate=2;
    }else{
      arr_q[i] = $('#q_'+i).val();
    }
    if($('#a_'+i).val()==''){
      $('#a_'+i).css({'border-color':'red'});
      validate=2;
    }else{
      arr_a[i] = $('#a_'+i).val();
    }
  }
  $('#generate').css({'display': 'none'});  
  $('#success').css({'display': ''});
  localStorage.word_arr_q = JSON.stringify(arr_q);
  localStorage.word_arr_a = JSON.stringify(arr_a);
  for(i = 0; i < 3; i++){
    if($('#tag_'+i).val().match(/\W/g) && 
      !$('#tag_'+i).val().match(/^[ぁ-んァ-ン一-龥]/)){
//     if($('#tag_'+i).val().match(/\W/g)){
      $('#tag_'+i).css({'border-color':'red'});
      validate=2;
    }
  }
  if(validate==2){
    return;
  }
  $('#generate').css({'display': 'none'});  
  $('#success').css({'display': ''});
  if(localStorage.myphoto){
    var myphoto = localStorage.myphoto;
  }else{
    var myphoto = '';
  }
  var param = {
    csrf : $.cookie('csrf')
    ,arr_q : arr_q
    ,arr_a : arr_a
    ,tag_0 : $('#tag_0').val()
    ,tag_1 : $('#tag_1').val()
    ,tag_2 : $('#tag_2').val()
    ,myphoto: myphoto
  };
  $.post('/4wordadd/',param,function(){},"json")
  .always(function(res){
    if(res[0]==1){
      localStorage.word_arr_q = [];
      localStorage.word_arr_a = [];
      if(localStorage.genestep){
        localStorage.genestep = localStorage.genestep + 1;
        location.href = '/myprofile/';
      }else{
        localStorage.genestep = 1;
        location.href = '/myprofile/';
      }
    }else{
      $('#success').css({'display': 'none'});
      $('#generate').css({'display': ''});  
      alert('connection error');
    }
  });
  ga('set', 'dimension3','gene_'+localStorage.genestep);
  ga('send','event','generate','4word',localStorage.ua_u_id,localStorage.genestep);
});


// .begin. make notify arr
var hour_stamp = Math.floor(new Date().getTime() /1000 /60 /60); 
if(localStorage.notify){
  var notify = JSON.parse(localStorage.notify);
  notify[1] = hour_stamp;
}else{
//last getNews() hour, last generate hour, read news or yet, new records, notify step number
  var notify = [0,hour_stamp,'nodata',0,0];
}
localStorage.notify = JSON.stringify(notify);
// .end. make notify arr
ga('send', 'pageview');
