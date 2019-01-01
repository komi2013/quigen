var endNum = 0;
var addLimit = 100;
var celNum = 0;

var translated = localStorage.translated ? JSON.parse(localStorage.translated) : [];

$('#generate').click(function(){
  if(!u_id){
    alert(answer_first);
    return;
  }
  var validate = 1;
  if($('#textbox').val()==''){
    $('#textbox').css({'border-color':'red'});
    validate=2;
  }
  if(validate==2){
    return;
  }
  if(localStorage.quest){
    var quest = JSON.parse(localStorage.quest);
    if(quest[7] != 1){
      quest[7] = 1;
      localStorage.quest = JSON.stringify(quest);
      notify[2] = 'yet';
      notify[3] = 1;
      notify[4] = notify[4]+1;
      if(localStorage.news){
        var news = JSON.parse(localStorage.news);
      }else{
        var news = [];
      }
      news.unshift('<a href="/htm/quest/">'+translated+'<img src="/assets/img/icon/star_1.png"></a>');
      localStorage.news = JSON.stringify(news);
      localStorage.notify = JSON.stringify(notify);
    }
  }
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
      $('#trans_a').text(res[1]);
      translated.unshift([$('#trans_q').val(),res[1]]);
      localStorage.translated = JSON.stringify(translated);
      var cellId = translated.length-1;
      var q = $('#trans_q').val();
      var a = res[1];
      var append = 
        '<tr class="del_'+cellId+'">'+
        '<td colspan="50" class="td_50">'+q+'</td>'+
        '<td colspan="50" class="td_50">'+a+'</td>'+
        '</tr><tr class="del_'+cellId+'">'+
        '<td colspan="50" class="td_49_t"></td>'+
        '<td colspan="50" class="td_50_t" id="position_'+cellId+'">'+
        '<img src="/assets/img/icon/trash.png" class="icon" onClick="delAnswer('+cellId+')">'+
        '</td>'+

        '</tr>';
      $('#cel').prepend(append);

      console.log(localStorage.translated);
    }else{
      $('#success').css({'display': 'none'});
      $('#generate').css({'display': ''});  
      alert('connection error');
    }
  });
//  var hour_stamp = Math.floor(new Date().getTime() /1000 /60 /60); 
//  var notify = JSON.parse(localStorage.notify);
//  notify[1] = hour_stamp;
//  localStorage.notify = JSON.stringify(notify);
//  ga('set', 'dimension3','gene_'+localStorage.genestep);
//  ga('send','event','generate','upload',localStorage.ua_u_id,localStorage.genestep*1);
});


addCel(translated);
//    translated.unshift([
//   0   trans_id  
//   1   ,trans_q
//   2   ,trans_a
//    ]);
function addCel(res){
  if(!res[0]){
    return;
  }
  while(celNum < addLimit){
    var cellId = celNum;
    var q = res[celNum][0];
    var a = res[celNum][1];
    var append = 
    '<tr class="del_'+cellId+'">'+
    '<td colspan="50" class="td_50">'+q+'</td>'+
    '<td colspan="50" class="td_50">'+a+'</td>'+
    '</tr><tr class="del_'+cellId+'">'+
    '<td colspan="50" class="td_49_t"></td>'+
    '<td colspan="50" class="td_50_t" id="position_'+cellId+'">'+
    '<img src="/assets/img/icon/trash.png" class="icon" onClick="delAnswer('+cellId+')">'+
    '</td>'+

    '</tr>';
    $('#cel').append(append);    
    ++celNum;
    if(!res[celNum]){
      return;
    }
  }
}

function delAnswer(cellId) {
console.log(translated);
  r = confirm(del);
  if(r){
    var new_translated = [];
    var i2 = 0;
    for(var i=0; i<translated.length; i++){
      if(i != cellId){
        new_translated[i2] = translated[i];
        i2++;
      }
    }
    setTimeout(function(){
      localStorage.translated = JSON.stringify(new_translated);
      $('.del_'+cellId).fadeOut('slow');
    },500);
  }
}

if(localStorage.quest){
  var quest = JSON.parse(localStorage.quest);
  if(quest[1] != 1){
    quest[1] = 1;
    localStorage.quest = JSON.stringify(quest);
    setTimeout(function(){
      highlighting('#page_news',0,false);
    },3000);
    var ticket = JSON.parse(localStorage.ticket);
    ticket[0] = ticket[0] + 12;
    localStorage.ticket = JSON.stringify(ticket);
    notify[2] = 'yet';
    notify[3] = 1;
    notify[4] = notify[4]+1;
    if(localStorage.news){
      var news = JSON.parse(localStorage.news);
    }else{
      var news = [];
    }
    news.unshift('<a href="/htm/quest/">translation is completed<img src="/assets/img/icon/star_1.png"></a>');
    localStorage.news = JSON.stringify(news);
    localStorage.notify = JSON.stringify(notify);
  }
}
$('#position').click(function(){
  location.href = '/htm/myanswer_offline/#position_'+localStorage.current_q;
});
