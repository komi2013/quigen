function checkClick(status,u_id){
  $('#u_img').css({'display': 'none'});
  $('#delete').css({'display': ''});
  $('#u_'+u_id+' .status').css({'display': 'none'});
  $('#u_'+u_id+' .chkbox').css({'display': ''});
  $('#u_'+u_id+' .chkbox').attr('checked', 'checked'); 
}

$('#delete').click(function(){
  r = confirm('delete');
  if(r){
    var arr_u=[];
    $('[name="u_id"]:checked').each(function(){
      arr_u.push($(this).val());
    });
    var param = {
      csrf : csrf
      ,arr_u : arr_u
      ,who : 'following'
      ,do : 'delete'
    };
    $.post('/followdo/',param,function(){},"json")
    .always(function(res){
      if(res[0]==1){
        location.href='';
      }else{
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
  var cellTxt = '';
  var celImg = '';
  while(celNum < addLimit){
    cellId = resData[celNum][0];
    cellTxt = resData[celNum][1];
    if(resData[celNum][2]){
      celImg = resData[celNum][2];
    }else{
      celImg = '/assets/img/icon/guest.png';
    }
    if(resData[celNum][3] == 2){
      statusImg = '<img src="/assets/img/icon/success.png" alt="confirmed" class="icon status">';
    }else{
      statusImg = '<img src="/assets/img/icon/hourglass.png" alt="pending request" class="icon status">';
    }
    var append = 
      '<tr><td class="td_15_t">'
      +'<a href="/profile/?u='+cellId+'" >'
      +'<img src="'+celImg+'" alt="following photo" class="icon"></a>'
      +'</td><td class="td_68_t">'
      +'<a href="/profile/?u='+cellId+'" >'+cellTxt+'</a>'
      +'</td><td class="td_15_t" onClick="checkClick('+resData[celNum][3]+','+cellId+')" id="u_'+cellId+'">'+statusImg
      +'<input type="checkbox" name="u_id" class="icon chkbox" value="'+cellId+'" style="display:none;">'
      +'</td></tr>'
    ;
    $('#cel').append(append);
    ++celNum;
    if(!resData[celNum]){
      return;
    }
  }
}

function getData(first){
  var param = {
    endNum : endNum,
    sender : sender
  };
  $.get('/followingshow/',param,function(res){
    if(res[0]==1){
      resData = $.merge($.merge([], resData), res[1]);
      endNum = res[1].pop()[0];
      if(first == 1){
        addCel(resData);
      }
    }else if(res[0]==2){
    }
  }, "json");
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
