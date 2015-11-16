quizUsrShow();
answer_by_q_show();

$('.choice').click(function(){
  $(this).css({
    'background-color': 'grey',
    'border-width': '1px 1px',
    'border-color': 'silver',
    'border-style': 'solid'
  });
  var this_seq = $(this); 
  setTimeout(function(){
    answer_1(this_seq);
  },2000);
});
function answer_1(this_seq){
  if(localStorage.myphoto){
    var myphoto = localStorage.myphoto;  
  }else{
    var myphoto = '/assets/img/icon/guest.png';
  }
  if(localStorage.myname){
    var myname = localStorage.myname;
  }else{
    var myname = 'guest';
  }
  var q_img = ($('#photo').attr('src'))? $('#photo').attr('src') : '' ;
  var arr_choice = [];
  for(i = 0; i < 4; i++){
    arr_choice[i] = $('#choice_'+i).html();
  }
  var param = {
    csrf : csrf
    ,answer : $(this_seq).html()
    ,question : q_id
    ,q_txt : $('#question').html()
    ,q_img : q_img
    ,usr : usr
    ,arr_choice : arr_choice
  };
  $.post('/paidanswer/',param,function(){},"json")
  .always(function(res){
    if(res[0]==1){
      if(res[1]==1){
        resCo.unshift([0,myname,myphoto]);
        var resAnswer = resCo;
        amt_co++;
        $('#big_correct').css({'display': ''});
        addCel(resCo,'co');
        csrf = res[1];
      }else{
        var correct_answer = 0; 
        resInco.unshift([0,myname,myphoto]);
        var resAnswer = resInco;
        $('#big_incorrect').css({'display': ''});
        $(this_seq).css({
          'background-color': 'red',
          'border-width': '1px 1px',
          'border-color': 'silver',
          'border-style': 'solid'
        });
        addCel(resInco,'inco');
      }
      $('#choice_'+res[2]).css({
        'background-color': 'green',
        'border-width': '1px 1px',
        'border-color': 'silver',
        'border-style': 'solid'
      });
    }else{
      alert('接続エラー');
    }
    already = 2;
    comment_show();
    amt_answer++;
    $('#num_ratio').empty().append(Math.round(amt_co/amt_answer * 100)+' %');
    $('#num_answer').empty().append(amt_answer);
    
    ga('set', 'dimension1','paid_an_'+correct_answer);  
    ga('send','event','paid_answer',correct_answer,usr,1);
  });
}
$('#sns td a').click(function(){
  ga('set','dimension9','share_'+$(this).children('img').attr('alt'));  
  ga('send','event','share','link',$(this).children('img').attr('alt'),1);  
});

//.begin. add in/correct usr
var resCo = [];
var resInco = [];
function addCel(resData,coinco){
  var celImg = '';
  var cellTxt = '';
  var append = '';
  for (var celNum=0;celNum<resData.length;celNum++){
    cellId = resData[celNum][0];
    cellTxt = resData[celNum][1];
    if(resData[celNum][2]){
      celImg = resData[celNum][2];
    }else{
      celImg = '/assets/img/icon/guest.png';
    }
    append = '<a href="/profile/?u='+cellId+'">'+
    '<img src="'+celImg+'" alt="answered usr" class="ans_icon"></a>'+
    '</td>';
    $('#'+coinco+'_'+celNum).empty().append(append);
    if(celNum > 14){
      return;
    }
  }
}
//.end. add in/correct usr

function quizUsrShow(){
  var param = {
    q : q_id,
    u : usr
  };
  var append = '';
  $.get('/payquizusrshow/',param,function(){},"json")
  .always(function(res){
//     res[1] = id, txt, img
    if(res[0]==1){
      append = 
      '<a href="/profile/?u='+res[1][0]+'">'+
      '<img src="'+res[1][2]+'" alt="quiz generator" class="icon"></a>';
      $('#right').append(append);
      if(localStorage.ua_u_id && localStorage.ua_u_id == res[1][0]){
        ga('set','dimension12','owner');
      }
      addCel(res[2],'co');
      addCel(res[3],'inco');
      resCo = res[2];
      resInco = res[3];
    }else{
      console.log(res);
    }
  });
}

var amt_co = 0;
var amt_answer = 0;
function answer_by_q_show(){
  var param = {
    q : q_id
    ,u : usr
  };
  $.get('/answerbypayqshow/',param,function(){},"json")
  .always(function(res){
    if(res[0]==1){
      amt_co = res[1][0];
      amt_answer = res[1][1];
      if(amt_co == 0){
        $('#num_ratio').empty().append(0+' %');
      }else{
        $('#num_ratio').empty().append(Math.round(amt_co/amt_answer * 100)+' %');
      }
      $('#num_answer').empty().append(amt_answer);
      
    }else{
     console.log(res);
    }
  });
}
function comment_show(){
  var param = {
    q : q_id
    ,pay : 1
  };
  $.get('/commentshow/',param,function(){},"json")
  .always(function(res){
//     res[1] = id, txt, img
    if(res[0]==1){
      addCelComment(res[1]);
    }else if(res[0]==2){
      comment();
    }else{
      alert('connection error');
      //console.log(res);
    }
  });
}

function addCelComment(resData){
  var cellTxt = '';
  var celImg = '';
  var cellId = 0;
  for (var celNum=0;celNum<resData.length;celNum++){
    cellId = resData[celNum][0];
    cellTxt = resData[celNum][1];
    if(resData[celNum][2]){
      celImg = resData[celNum][2];
    }else{
      celImg = '/assets/img/icon/guest.png';
    }
    var append = 
    '<tr><td class="td_15_c">'+
    '<a href="/profile/?u='+cellId+'" >'+
    '<img src="'+celImg+'" alt="follower photo" class="icon"></a>'+
    '</td><td class="td_84_c">'+cellTxt+'</td></tr>';
    $('#comment').append(append);
  }
  comment();
}
function comment(){
  var append = '<tr><td class="td_84_c"><input type="text" placeholder="コメント" class="input_txt" id="comment_data"></td><td class="td_15_c">'+
    '<a href="#"><img src="/assets/img/icon/upload_0.png" alt="generate" class="icon" id="generate">'+
    '<img src="/assets/img/icon/success.png" alt="success" class="icon" id="success" style="display:none;"></a>'+
    '</td></tr>';
  $('#comment_in').append(append);
  $('#generate').click(function(){
    var validate = 1;
    if($('#comment_data').val()==''){
      $('#comcomment_data').css({'border-color':'red'});
      validate=2;
    }
    if(validate==2){
      return false;
    }
    $('#generate').css({'display': 'none'});
    $('#success').css({'display':''});
    var param = {
      csrf : csrf
      ,txt : $('#comment_data').val()
      ,q : q_id
      ,pay : 1
    };
    $.post('/commentadd/',param,function(){},"json")
    .always(function(res){
      if(res[0]==1){
        location.href = '';
      }else{
        alert('connection error');
      }
    });
    ga('set','dimension14','comment');  
    ga('send','event','comment',usr,$('#comment_data').val(),1);  
    return false;
  });
}

function commentAdd(){
  var param = {
    q : q_id
    ,pay : 1
  };
  $.get('/commentshow/',param,function(){},"json")
  .always(function(res){
//     res[1] = id, txt, img
    if(res[0]==1){
      addCelComment(res[1]);
    }else{
      alert('connection error');
      console.log(res);
    }
  });  
}
