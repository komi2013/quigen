var word4 = localStorage.word4 ? JSON.parse(localStorage.word4) : [];
var translated = localStorage.translated ? JSON.parse(localStorage.translated) : [];
var arr_q = [];
for(i = 0; i < 4; i++){
  if(word4[i]){
    arr_q[i] = word4[i][0];
  }
}
var trans_i = -1;
for(i = 0; i < 4; i++){
  if(word4[i]){
    $('#q_'+i).val(word4[i][0]);
    $('#a_'+i).val(word4[i][1]);
  } else if(translated) {
      for (var i2 = 0; i2 < translated.length; i2++){
        console.log('search:'+arr_q.indexOf(translated[i2][0]) + trans_i + i2);
//        console.log('trans_i:'+trans_i);
//        console.log('i2:'+i2);
        if(arr_q.indexOf(translated[i2][0]) == -1 && trans_i < i2 && !translated[i2][2]){
          $('#q_'+i).val(translated[i2][0]);
          $('#a_'+i).val(translated[i2][1]);
          translated[i2][2] = 1;
          trans_i = i2;
          i2 = translated.length;
        }          
      }
  }
}

$('#generate').click(function(){
  if(!u_id){
    alert('answer first');
    return;
  }
  var validate = 1;
  var word4 = [];
  for(i = 0; i < 4; i++){
    if($('#q_'+i).val()==''){
      $('#q_'+i).css({'border-color':'red'});
      validate=2;
    }
    if($('#a_'+i).val()==''){
      $('#a_'+i).css({'border-color':'red'});
      validate=2;
    }
    if($('#q_'+i).val() || $('#a_'+i).val()){
      word4[i] = [$('#q_'+i).val(),$('#a_'+i).val()];
      
    }
  }
  $('#generate').css({'display': 'none'});  
  $('#success').css({'display': ''});
  localStorage.word4 = JSON.stringify(word4);
  for(i = 0; i < 3; i++){
    if($('#tag_'+i).val().match(/\W/g) && 
      !$('#tag_'+i).val().match(/^[ぁ-んァ-ン一-龥]/)){
//     if($('#tag_'+i).val().match(/\W/g)){
      $('#tag_'+i).css({'border-color':'red'});
      validate=2;
    }
  }
  if(validate==2){
    $('#success').css({'display': 'none'});
    $('#generate').css({'display': ''});  
    return;
  }
  var myphoto = localStorage.myphoto ? localStorage.myphoto : '';
  var myname = localStorage.myname ? localStorage.myname : '';
  var param = {
    csrf : csrf
    ,word4 : word4
    ,tag_0 : $('#tag_0').val()
    ,tag_1 : $('#tag_1').val()
    ,tag_2 : $('#tag_2').val()
    ,myphoto: myphoto
    ,myname: myname
  };
  $.post('/4wordadd/',param,function(){},"json")
  .always(function(res){
    if(res[0]==1){
      localStorage.word4 = [];
      localStorage.translated = JSON.stringify(translated);
      if(localStorage.genestep){
        localStorage.genestep = localStorage.genestep + 1;
        location.href = '/myprofile/?list=forum';
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

$('input').keypress(function (e) {
  var key = e.which;
  if(key == 13) {
    $('#generate').click();
    return false;
  }
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

if(!localStorage.login){
  alert(please_login);
  location.href = '/htm/myprofile/';
}

