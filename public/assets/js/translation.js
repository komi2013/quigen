var endNum = 0;
var addLimit = 100;
var celNum = 0;

var translated = localStorage.translated ? JSON.parse(localStorage.translated) : [];

var content = new Vue({
  el: '#content',
  data: {
      translated: translated
  }
});
$('.del').on('click',function(){
  r = confirm(del);
  if(r){
    var key = $(this).attr('del_k');
    $('.del_'+key).fadeOut(400,function(){$(this).fadeIn(500)});
    setTimeout(function(){
      translated.splice(key, 1);
      localStorage.translated = JSON.stringify(translated);
    },500);
  }
});
$('.switch').on('click',function(){
  var key = $(this).attr('switch_k');
  var arr_switch = [translated[key][1],translated[key][0]];
  translated[key] = arr_switch;
  Vue.set(translated, key, arr_switch);
  localStorage.translated = JSON.stringify(translated);
});
var clicked = 0;
$('#generate').click(function(){
  if(clicked == 2){
    return;
  }
  clicked = 2;
  if(!localStorage.ua_u_id){
    alert(answer_first);
    return;
  }
  var validate = 1;
  if($('#trans_q').val()==''){
    $('#trans_q').css({'border-color':'red'});
    validate=2;
  }
  if(validate==2){
    return;
  }
//  if(localStorage.quest){
//    var quest = JSON.parse(localStorage.quest);
//    if(quest[7] != 1){
//      quest[7] = 1;
//      localStorage.quest = JSON.stringify(quest);
//      notify[2] = 'yet';
//      notify[3] = 1;
//      notify[4] = notify[4]+1;
//      if(localStorage.news){
//        var news = JSON.parse(localStorage.news);
//      }else{
//        var news = [];
//      }
//      news.unshift('<a href="/htm/quest/">'+translated+'<img src="/assets/img/icon/star_1.png"></a>');
//      localStorage.news = JSON.stringify(news);
//      localStorage.notify = JSON.stringify(notify);
//    }
//  }
  $('#generate').css({'display': 'none'});  
  $('#success').css({'display': ''});
  var param = {
    csrf : csrf
    ,trans_q : $('#trans_q').val()
    ,native : $('[name="native"] option:selected').val()
  };
  $.post('/translate/',param,function(){},"json")
  .always(function(res){
    if(res[0]==1){
      translated.unshift([$('#trans_q').val(),res[1]]);
      localStorage.translated = JSON.stringify(translated);
    }else{
      alert('connection error');
    }
    $('#trans_q').val('');
    $('#success').css({'display': 'none'});
    $('#generate').css({'display': ''});
    clicked = 1;
  });
//  var hour_stamp = Math.floor(new Date().getTime() /1000 /60 /60); 
//  var notify = JSON.parse(localStorage.notify);
//  notify[1] = hour_stamp;
//  localStorage.notify = JSON.stringify(notify);
//  ga('set', 'dimension3','gene_'+localStorage.genestep);
//  ga('send','event','generate','upload',localStorage.ua_u_id,localStorage.genestep*1);
});