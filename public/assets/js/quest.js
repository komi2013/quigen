if(localStorage.last_q){
  $('#pre_quiz').attr('href','/quiz/?q='+localStorage.last_q);
}

var hour_stamp = Math.floor(new Date().getTime() /1000 /60 /60);
if(localStorage.ticket){
  var ticket = JSON.parse(localStorage.ticket);
  if(ticket[3] == 10){ //only temporary for immigration time
    ticket[3] = 50;
  }
}else{
  var ticket = [10,1,hour_stamp,50]; //ticket,span,time,capacity
}
var recover = Math.floor( (hour_stamp - ticket[2]) / ticket[1] );
var formatDate = function (date, format) {
  if (!format) format = 'YYYY-MM-DD hh:mm:ss.SSS';
  format = format.replace(/YYYY/g, date.getFullYear());
  format = format.replace(/MM/g, ('0' + (date.getMonth() + 1)).slice(-2));
  format = format.replace(/DD/g, ('0' + date.getDate()).slice(-2));
  format = format.replace(/hh/g, ('0' + date.getHours()).slice(-2));
  format = format.replace(/mm/g, ('0' + date.getMinutes()).slice(-2));
  format = format.replace(/ss/g, ('0' + date.getSeconds()).slice(-2));
  if (format.match(/S/g)) {
    var milliSeconds = ('00' + date.getMilliseconds()).slice(-3);
    var length = format.match(/S/g).length;
    for (var i = 0; i < length; i++) format = format.replace(/S/, milliSeconds.substring(i, i + 1));
  }
  return format;
};

if(localStorage.quest){
  var quest = JSON.parse(localStorage.quest);
  for(var i = 0; i < quest.length; i++){
    if(quest[i] == 1){
      $('#img_quest_'+[i]).empty().append('<img src="/assets/img/icon/star_1.png">');
    }
  }
}else{
  var quest = [0,0,0,0,0,0,0,0];
  localStorage.quest = JSON.stringify(quest);
}

var quested = 0;
if(localStorage.quest_level){
  if(localStorage.quest_level == 2){
    if(quest[3] == 1 && quest[4] == 1 && quest[5] == 1 && quest[6] == 1 && quest[7] == 1){
      localStorage.quest_level = 3;
      ticket[1] = 0.5;
      ticket[0] = 100;
      ticket[3] = 100;
      quested = 1;
      highlighting('#light_1',0,false);
      $('#light_1').empty().append('<img src="/assets/img/icon/star_1.png"><img src="/assets/img/icon/star_1.png">');
    }else{
      $('.quest_2').css({ 'display': ''});
      
      if(recover > ticket[3]){
        recover = ticket[3];
      }
    }
  }else if(localStorage.quest_level == 3){
    if(recover > ticket[3]){
      recover = ticket[3];
    }
  }else{
    if(recover > ticket[3]){
      recover = ticket[3];
    }
  }
}else{
  if(quest[0] == 1 && quest[1] == 1 && quest[2] == 1){
    $('.quest_2').css({ 'display': ''});
    localStorage.quest_level = 2;
    ticket[1] = 1;
    ticket[0] = 50;
    ticket[3] = 50;
    quested = 1;
    highlighting('#light_1',0,false);
    $('#light_1').append('<img src="/assets/img/icon/star_1.png">');
  }else{
    $('.quest_2').css({ 'display': 'none' }); 
    if(recover > ticket[3]){
      recover = ticket[3];
    }
  }
}

if(recover > 0 || quested == 1){
  ticket[2] = hour_stamp;
  if(ticket[0] < 0){
    ticket[0] = 0;
  }
  ticket[0] = ticket[0] + recover;
  if(getVal.q){
    location.href = '/quiz/?q='+getVal.q;
  }
}
if(ticket[0] < ticket[3]){
  var now = new Date();
  var left_second = 60 - now.getSeconds();
  var left_minute = 59 - now.getMinutes();
  var left_hour = 0;
  function show_time(){
    var m = ('0' + left_minute).slice(-2);
    var s = ('0' + left_second).slice(-2);
    $('#left_time').empty().append(left_hour+':'+m+':'+s);
    if(left_second < 1){
      left_second = 60;
      --left_minute;
    }
    if(left_minute < 1){
      left_minute = 60;
      left_hour = -1;
    }
    --left_second;
  }
  if(left_hour > -1){
    setInterval('show_time()',1000);
  }
  var open_time = formatDate(new Date( (ticket[2] + 1) * 60 * 60 * 1000), 'YYYY-MM-DD hh:mm:ss');
  $('#open_time').empty().append(open_time);  
}else if(ticket[0] > ticket[3]) {
  ticket[0] = ticket[3];
}
if(ticket[0] > 0){
  $('#ticket').css({ 'color': 'green' });
  $('#ticket').empty().append(ticket[0]);
  $('#light_2').empty().append('○下記の時間以降に回答できます');
  localStorage.ticket = JSON.stringify(ticket);
}

if(localStorage.point){
  $('#point').empty().append(localStorage.point+' pt');
}

$('#generate').click(function(){
  if(!u_id){
    alert('はじめにクイズに答えてください');
    return;
  }
  if( !$('input[name=pay_point]:checked').val() ){
    $('input[name=pay_point]').css({'border-color':'red'});
    return;
  }
  if( !localStorage.point || $('input[name=pay_point]:checked').val() > localStorage.point){
    alert('ポイントが足りません');
    return;
  }
  $('#generate').css({'display': 'none'});
  $('#success').css({'display': ''});
  var param = {
    csrf : csrf
    ,pay  : $('input[name=pay_point]:checked').val()
    ,type : 'from_quest'
  };
  $.post('/pointpay/',param,function(){},"json")
  .always(function(res){
    if(res[0]==1){
      localStorage.point = res[1]*1;
      switch ( $('input[name=pay_point]:checked').val() ) {
        case '100':  var buy_ticket =  20; break;
        case '800':  var buy_ticket = 170; break;
        case '1400': var buy_ticket = 300; break;
      }
      if(localStorage.ticket){
        var ticket = JSON.parse(localStorage.ticket);  
      }else{
        var ticket = [5,1,hour_stamp,5];
      }
      ticket[0] = ticket[0] + buy_ticket;
      localStorage.ticket = JSON.stringify(ticket);
      location.href = '';
    }else{
      $('#success').css({'display': 'none'});  
      $('#generate').css({'display': ''});
      alert('connection error');
    }
  });
});

