if(getVal.warn){
  alert('他のアカウントのログアウト・削除してから、ログイン・同期してください');
  location.href = '/myprofile/';
}

if(localStorage.quest){
  var quest = JSON.parse(localStorage.quest);
  if(quest[2] != 1){
    quest[2] = 1;
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
    news.unshift('<a href="/htm/quest/">マイページを確認しました<img src="/assets/img/icon/star_1.png"></a>');
    localStorage.news = JSON.stringify(news);
    localStorage.notify = JSON.stringify(notify);
  }
}

if(localStorage.follow){
  var follow = JSON.parse(localStorage.follow);
  $('#num_following').empty().append(follow.length); 
}

$('.auth').click(function(){
  r = confirm('ログイン・同期します');
  if(r){
    (localStorage.myphoto)? myphoto = localStorage.myphoto : myphoto = '';
    (localStorage.myname)? myname = localStorage.myname : myname = '';
    (localStorage.answer_by_u)? answer_by_u = localStorage.answer_by_u : answer_by_u = [];
    (localStorage.answer)? answer = localStorage.answer : answer = [];
    ga('set', 'dimension10',$(this).attr('alt'));
    ga('send','event','auth',$(this).attr('alt'),localStorage.ua_u_id,1);
    location.href = $(this).data('url');
  }
});

var childWindow;
$('#photo').click(function() {
  if(!u_id){
    alert('はじめにクイズに答えてください');
    return;
  }
  childWindow = window.open("/htm/photo/", "winB");
});
function winCloseB(){
  childWindow.close();
  var param = {
    csrf : csrf
    ,img : localStorage.getItem('img')
  };
  $.post('/photoprofileadd/',param,function(){},"json")
  .always(function(data){
    if(data[0] == 1){
      localStorage.myphoto = data[1];
    }else{
      alert('connection error');
    }
  });
}

$('#generate').click(function(){
  if(!u_id){
    alert('はじめにクイズに答えてください');
    return;
  }
  var validate = 1;
  if($('#myname').val()==''){
    $('#myname').css({'background-color':'red'});
    validate=2;
  }
  if(!localStorage.myphoto){
    $('#photo_res').css({'background-color':'red'});
    validate=2;
  }
  if(validate==2){
    return;
  }
  r = confirm('プロファイルを変更します');
  if(r){
    $('#generate').css({'display': 'none'});  
    $('#success').css({'display': ''});
    var param = {
      csrf : csrf
      ,myname : $('#myname').val()
      ,introduce:  $('#introduce').val()
      ,myphoto : localStorage.myphoto
    };
    $.post('/myprofileadd/',param,function(){},"json")
    .always(function(res){
      if(res[0]==1){
        localStorage.removeItem('img');
        localStorage.myname = $('#myname').val();
        location.href='';
      }else{
        $('#success').css({'display': 'none'});
        $('#generate').css({'display': ''});  
        alert('connection error');
      }
    });
    ga('send','event','myprofile','upload','edit',1);
  }
});

$('input').keypress(function (e) {
  var key = e.which;
  if(key == 13) {
    $('#generate').click();
    return false;  
  }
});

function checkClick(){
  $('#generate').css({'display': 'none'});  
  $('#delete').css({'display': ''});
  var check_empty = 1;
  $('[name="quiz_id"]:checked').each(function(){
    check_empty = 0;
  });
  if(check_empty == 1){
    $('#delete').css({'display': 'none'});
    $('#generate').css({'display': ''});  
  }
}

$('#del_cookie').click(function(){
  r = confirm('ログアウト・削除します');
  if(r){
    localStorage.clear();
    $.post('/myprofiledel/',{csrf:csrf},function(){},"json")
    .always(function(res){
      if(res[0]==1){
        location.href='';
      }
    });
  }
});

if(getVal.list){
  function delQuiz(cellId){
    r = confirm('削除します');
    if(r){
      var quiz_id=[cellId];
      var param = {
        csrf : csrf
        ,quiz_id : quiz_id
      };
      $.post('/myquizdelete/',param,function(){},"json")
      .always(function(res){
        if(res[0]==1){
          location.href='';
        }
      });  
    }
  }
  var endTime = Math.round( new Date().getTime() / 1000 );
  endTime = endTime + 86400 * 20;
  var addLimit = 20;
  var celNum = 0;
  var resData = [];
  function addQ(resData){
    while(celNum < addLimit){
      var cellId = resData[celNum][0];
      var cellTxt = resData[celNum][1];
      if(resData[celNum][2]){
        var append = 
        '<tr><td colspan="15" class="td_15">'+
        '<a href="/quiz/?q='+cellId+'">'+
        '<img src="'+resData[celNum][2]+'" alt="quiz" class="icon"></a>'+
        '</td><td colspan="85" class="td_84">'+
        '<a href="/quiz/?q='+cellId+'">'+cellTxt+
        '</a></td>'+
        '</tr><tr>'+
        '<td colspan="50" class="td_49_t"><a href="/quizedit/?q='+cellId+'"><img src="/assets/img/icon/pencil.png" alt="edit" class="icon"></a></td>'+
        '<td colspan="50" class="td_50_t"><img src="/assets/img/icon/trash.png" alt="delete" class="icon" onClick="delQuiz('+cellId+')"></td>'+
        '</tr>';
      }else{
        var append = 
        '<tr><td colspan="100" class="td_99">'+
        '<a href="/quiz/?q='+cellId+'">'+cellTxt+
        '</a></td>'+
        '</tr><tr>'+
        '<td colspan="50" class="td_49_t"><a href="/quizedit/?q='+cellId+'"><img src="/assets/img/icon/pencil.png" alt="edit" class="icon"></a></td>'+
        '<td colspan="50" class="td_50_t"><img src="/assets/img/icon/trash.png" alt="delete" class="icon" onClick="delQuiz('+cellId+')"></td>'+
        '</tr>';
      }
      $('#cel').append(append);
      ++celNum;
      if(!resData[celNum]){
        return;
      }
    }
  }

  function getData(first){
    var param = {
      endTime : endTime
    };
    $.get('/myquestionshow/',param,function(){},"json")
    .always(function(res){
  //     resData = id, txt, img
      if(res[0]==1){
        resData = $.merge($.merge([], resData), res[1]);
        endTime = res[1].pop()[4];
        if(first == 1){
          addQ(resData);
        }
      }else if(res[0]==2){
      }
    });
  }

  var dataLimit = 80;
  getData(1);
  var detect = 300;
  $(window).scroll(function(){
    var scrTop = $(document).scrollTop();
    if(scrTop > detect){
      detect = detect + 300;
      addLimit = addLimit + 20;
      if(addLimit > dataLimit){
        dataLimit = dataLimit + 80;
        getData();
      }
      if(resData[celNum]){
        addQ(resData);
      }
    }
  });

}else{
  var endNum = 0;
  var addLimit = 100;
  var celNum = 0;
  if(localStorage.answer){
    var answer = JSON.parse(localStorage.answer);
  }else{
    var answer = [];
  }

  var offline_q = [];
  if(localStorage.offline_q){
    offline_q = JSON.parse(localStorage.offline_q);
  }

  addCel(offline_q);
  //    offline_q.unshift([
  //   0   $('#question').html()  
  //   1   ,$('#choice_0').html()
  //   2   ,$('#choice_1').html()
  //   3   ,$('#choice_2').html()
  //   4   ,$('#choice_3').html()
  //   5   ,correct
  //   6   ,$('#photo').attr('src')
  //   7   ,q_id
  //   8   ,comment_offline
  //   9   ,$(this_seq).html()  my answer
  //  10   ,quiz_num  my answer
  //    ]);
  function addCel(res){
    if(!res[0]){
      return;
    }
    while(celNum < addLimit){
      var cellId = res[celNum][7];
      var cellTxt = res[celNum][0];
      if(res[celNum][5] == res[celNum][9]){
        var result = '<img src="/assets/img/icon/circle_big.png" alt="correct" class="icon result" id="img_'+cellId+'">';
      }else{
        var result = '<img src="/assets/img/icon/cross_big.png" alt="incorrect" class="icon result" id="img_'+cellId+'">';
      }
      var quiz_num_txt = '';
      if(res[celNum][10]){
        quiz_num_txt = '第'+res[celNum][10]+'問.'; // only migration time cz localstorage data
      }
      var append = 
      '<tr><td colspan="100" class="td_84">'+
      '<a href="/quiz/?q='+cellId+'">'+result+quiz_num_txt+decodeURIComponent(cellTxt.replace(/\+/g,'%20').replace(/<br>/g,'')).substring(0,30)+
      '...</a>'+
      '</td>'+
      '</tr><tr>'+
      '<td colspan="50" class="td_49_t">'+
      '<img src="/assets/img/icon/no_internet.png" alt="offline" class="icon" onClick="goOffline('+cellId+')">'+
      '</td>'+
      '<td colspan="50" class="td_50_t"><img src="/assets/img/icon/trash.png" alt="delete" class="icon" onClick="delAnswer('+cellId+')"></td>'
      '</tr>';
      $('#cel').append(append);    
      ++celNum;
      if(!res[celNum]){
        return;
      }
    }
  }

  function delAnswer(cellId) {
    r = confirm('削除します');
    if(r){
      var new_answer = [];
      var ii=0;
      for(var i=0; i<answer.length; i++){
        if(answer[i][0] != cellId){
          new_answer[ii] = answer[i];
          ii++;
        }
      }
      var new_offline_q = [];
      var i2 = 0;
      for(var i=0; i<offline_q.length; i++){
        if(offline_q[i][7] != cellId){
          new_offline_q[i2] = offline_q[i];
          i2++;
        }
      }
      setTimeout(function(){
        localStorage.answer = JSON.stringify(new_answer);
        localStorage.offline_q = JSON.stringify(new_offline_q);
        location.href = '';
      },1000);
    }
  }
  function goOffline(cellId) {
    localStorage.current_q = cellId;
    location.href = '/htm/quiz_offline/ ';
  }
}

if(localStorage.answer_by_u){
  var answer_by_u = JSON.parse(localStorage.answer_by_u);
  $('#num_answer').empty().append(answer_by_u[1]);
  if(answer_by_u[1] > 0){
    $('#num_ratio').empty().append(Math.round(answer_by_u[0]/answer_by_u[1] * 100)+' %');
  }else{
    $('#num_ratio').empty().append('0 %');
  }
}

var rank = ''
  +'<tr>'
    +'<td class="td_68_c">タグカテゴリ</td>'
    +'<td class="td_15"><img src="/assets/img/icon/circle_big.png" class="icon"></td>'
    +'<td class="td_15"><img src="/assets/img/icon/ranking.png" class="icon"></td>'
  +'</tr>';

$.get('/myanswershow/',{},function(){},"json")
.always(function(res){
  if(res[0]==1){
    for (var i=0; i<res[1].length; i++){
      rank = rank+''
        +'<tr>'
          +'<td class="td_68_c"><a href="/search/?tag='+decodeURIComponent(res[1][i][0])+'">'+decodeURIComponent(res[1][i][0])+'</a></td>'
          +'<td class="td_15">'+res[1][i][1]+'</td>'
          +'<td class="td_15">'+res[1][i][2]+'</td>'
        +'</tr>';
    }
    $('#rank').append(rank);
  }else if(res[0]==2){
  }
});

