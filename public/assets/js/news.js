if(localStorage.news){
  var news = JSON.parse(localStorage.news);
  for(var i=0;i<news.length;i++){
    var append = '<tr><td class="td_99_t">'+news[i]+'</td></tr>';
    $('#cel').append(append);
  }
  if(news.length > 19){ //limit is 20
    var diff = news.length - 20;
    news.splice(-diff, diff);
  }
  var notify = JSON.parse(localStorage.notify);
  notify[2] = 'read';
  localStorage.notify = JSON.stringify(notify);
  localStorage.news = JSON.stringify(news);
}
function accept(quiz_buy_id){
  r = confirm('sell?');
  if(r){
    var param = {
      csrf : csrf
      ,quiz_buy_id : quiz_buy_id
    };
    $.post('/quizbuyaccept/',param,function(){},"json")
    .always(function(res){
      if(res[0]==1){
        csrf = res[1];
      }else{
        alert('connection error');
      }
    });
  }
  return false;
}

function follow_confirm(sender){
  r = confirm('follow confirm');
  if(r){
    var param = {
      csrf : csrf
      ,sender : sender
      ,receiver_img : localStorage.myphoto
    };
    $.post('/followingconfirm/',param,function(){},"json")
    .always(function(res){
      if(res[0]==1){
        var news = JSON.parse(localStorage.news);
        for(var i=0;i<news.length;i++){
//          console.log('begin');
//          console.log(news[i]);
//          console.log(news[i].search(/follow_confirm/));
//          console.log(news[i].search(sender));
//          console.log('end');
          if(news[i].search(/follow_confirm/) > -1 && news[i].search(sender) > -1){
            news[i] = news[i].replace("star_0","star_1");
            news[i] = news[i].replace("sccess_0","sccess");
//            console.log(news[i]);
          }
        }
        localStorage.news = JSON.stringify(news);
        csrf = res[1];
      }else{
        alert('connection error');
      }
    });
    //location.href = "";
  }
}
