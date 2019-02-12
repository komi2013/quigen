var hour_stamp = Math.floor(new Date().getTime() /1000 /60 /60);
if(localStorage.notify){  //[396105,396413,"read",1,2]
  var notify = JSON.parse(localStorage.notify);
  var chk = 2;
  //393009 hour = 2014-11-01 18:00:00 
  if(notify[0] < hour_stamp -24){ //news[0] last checked time
    chk = 1;
  }
  if( notify[0] < hour_stamp -1 && notify[1] > hour_stamp -24){ //news[1] last generated and answered time
    chk = 1;
  }
  if(notify[2] == 'yet'){ //current news wasn't read yet
    if(notify[3] > 0){
      $('#news_num').empty().append(notify[3]);
      $('#news_num').css('display','inline');
      $('title').prepend(' ('+notify[3]+')');
    }
    chk = 2;
  }
  if(!localStorage.offline_q){
    chk = 2;
  }
  if(chk == 1){
    getNews();
  }
}else{
  localStorage.notify = JSON.stringify([hour_stamp,0,"read",0,0]);
}

function getNews(){
  var notify = JSON.parse(localStorage.notify);
  var resData = JSON.parse(localStorage.offline_q);
  var celNum = 0;
  var arrCellId = [];
  if(resData.length){
    while(celNum < 1000){
      arrCellId[celNum] = resData[celNum][7];
      ++celNum;
      if(!resData[celNum]){
        celNum = 1000;
      }
    }      
  }
  if(localStorage.follow){
    var follow = JSON.parse(localStorage.follow);
  }else{
    var follow = [];
  }

  var param = {
    last_checked : notify[0]
    ,arr_myanswer_id : arrCellId
    ,follow : follow
  };
  // select * from a_news_time
  // follow check array with exisist
  // with image
  // when you answered, you need to update time localStorage.notify[1]
  
  $.get('/newsshow/',param,function(){},"json")
  .always(function(res){
    if(res[0]==1){
      $('#news_num').empty().append(res[1].length);
      $('#news_num').css('display','inline');
      $('title').prepend(' ('+res[1].length+')');
      //$('.unread').prepend(' ('+res[1].length+')');
      if(notify[4] < 3){
        var limit = 0;
        while(limit < 3){
          $('#page_news').fadeOut(1000,function(){
            $(this).css("background-color","yellow");
          }).fadeIn(1000);
          ++limit;
        }
      }
      notify[2] = 'yet';
      notify[3] = res[1].length;
      notify[4] = notify[4]+1;  //notify step number
      if(localStorage.news){
        var news = JSON.parse(localStorage.news);
      }else{
        var news = [];
      }
//       console.log(news);
      for (var i=0;i<res[1].length;i++){
        news.unshift(res[1][i]);
      }
//       console.log(news);
      localStorage.news = JSON.stringify(news);
      localStorage.notify = JSON.stringify(notify);
      ga('send','event','news','receive',notify[4],notify[3]);
    }else{
  //      console.log('no data from API');
    }
  });
  var hour_stamp = Math.floor(new Date().getTime() /1000 /60 /60);
  notify[0] = hour_stamp;
  localStorage.notify = JSON.stringify(notify);
}
