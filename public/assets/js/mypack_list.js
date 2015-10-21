if(localStorage.point){
  var point = localStorage.point;
}else{
  var point = 0;
}
$('#point').empty().append(point+' pt');

var add_upd = 1;
$('#generate').click(function(){
  if(!u_id){
    alert('はじめにクイズに答えてください');
    return;
  }
  var validate = 1;
  if(add_upd == 2){
    validate=2;
  }
  if($('#pack_txt').val()==''){
    $('#pack_txt').css({'background-color':'red'});
    validate=2;
  }
  if(validate==2){
    return;
  }
  $('#generate').css({'display': 'none'});  
  $('#success').css({'display': ''});
  var param = {
    csrf : csrf
    ,pack_txt : $('#pack_txt').val()
  };
  $.post('/packadd/',param,function(){}, "json")
  .always(function(res){
    if(res[0]==1){
      location.href = '';
    }else{
      $('#success').css({'display': 'none'});
      $('#generate').css({'display': ''});  
      alert('connection error');
    }
  });
});

function radioClick(cellId){
  $('#generate').css({'display':'none'});
  $('#delete').css({'display':''});
  $('#pack_'+cellId).attr("readonly", false);
  $('#pack_'+cellId).css("border", 'solid');
  $('#pack_'+cellId).css("background-color", "white");
  $('#pack_'+cellId).unwrap();
  add_upd = 2;
}
function inputClick(){
  $('#delete').css({'display':'none'});
  $('#generate').css({'display':''});
}
$('#delete').click(function(){
  r = confirm('削除します');
  if(r){
    $('#delete').css({'display': 'none'});
    $('#deleted').css({'display': ''});  
    var param = {
      csrf : csrf
      ,pack_id : $('[name="pack_id"]:checked').val()
    };
    $.post('/packdel/',param,function(){},"json")
    .always(function(res){
      if(res[0]==1){
        csrf = res[1];
      }else{
        $('#deleted').css({'display': 'none'});
        $('#delete').css({'display': ''});  
        alert('connection error');
      }
    });
  }
});

var endNum = 0;
var addLimit = 20;
var celNum = 0;
var resData = [];
function addCel(resData){
  while(celNum < addLimit){
    var cellId = resData[celNum][0];
    var cellTxt = resData[celNum][1];
    var cellStatus = resData[celNum][2];
    var append_1 = 
    '<tr>'+
    '<td class="pack_title_0">'+
    '<a href="/mypack/?p='+cellId+'">'+
    '<input type="text" value="'+cellTxt+'" readonly class="input_txt_0" id="pack_'+cellId+'" onClick="inputClick()"><a/>'+
    '</td><td class="td_15_0" onClick="radioClick('+cellId+')">'+
    '<input type="checkbox" name="pack_id" class="icon" value="'+cellId+'">'+
    '</td></tr>';
    var append_2 = 
    '<tr>'+
    '<td colspan="3" class="pack_title_1">'+
    '<a href="/mypack/?p='+cellId+'">'+
    '<input type="text" value="'+cellTxt+'" readonly class="input_txt_1"></a>'+
    '</td></tr>';
    if(cellStatus == 0){
      $('#cel').append(append_1);
    }else{
      $('#cel').append(append_2);
    }
    ++celNum;
    if(!resData[celNum]){
      return;
    }
  }
}

function getData(first){
  var param = {
    endNum : endNum
  };
  $.get('/mypackshow/',param,function(){},"json")
  .always(function(res){
//     resData = id, txt, img
    if(res[0]==1){
      resData = $.merge($.merge([], resData), res[1]);
      endNum = res[1].pop()[0];
      if(first == 1){
        addCel(resData);
      }
      if(res[2]==0){ // not activate
        $('#pack_input').css({'display': 'none'});
      }
    }else if(res[0]==2){
    }
    $('#generate').click(function(){
      if(add_upd == 2){
        $('#generate').css({'display': 'none'});
        $('#success').css({'display': ''});
        var param = {
          csrf : csrf
          ,pack_id : $('[name="pack_id"]:checked').val()
          ,txt : $('.input_txt_0').val()
        };
        $.post('/packupd/',param,function(){}, "json")
        .always(function(res){
          if(res[0]==1){
            csrf = res[1];
          }else{
            $('#success').css({'display': 'none'});
            $('#generate').css({'display': ''});  
            alert('connection error');
          }
        });
      }
    });
  });
}

var dataLimit = 80;
$(function(){
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
        addCel(resData);
      }
    }
  });
});

ga('send', 'pageview');