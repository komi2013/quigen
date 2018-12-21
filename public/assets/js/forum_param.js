var intermittent = true;
var arr_nice = localStorage.nice ? JSON.parse(localStorage.nice) : [];
for (var i=0; i<arr_nice.length; i++){
  for (var ii=0; ii<arr_forum.length; ii++){
    if(arr_nice[i] == arr_forum[ii]){
      is_nice = true;
      $('#f_nice_img_'+arr_forum[ii]).attr({'src': '/assets/img/icon/thumbup_1.png'});
    }
  }
}

$('.nice').click(function(){
  var is_nice = false;
  var f_id = $(this).data('forum');
  for (var i=0; i<arr_nice.length; i++){
    if( arr_nice[i] == f_id){
      is_nice = true;
    }
  }
  if (!is_nice && intermittent) {
    intermittent = false;
    var amt_nice = $('#f_nice_amt_'+f_id ).text();
    $('#f_nice_amt_'+f_id).text(amt_nice*1 + 1);
    $('#f_nice_amt_'+f_id).css({'display': ''});
    $('#f_nice_img_'+f_id).attr({'src': '/assets/img/icon/thumbup_1.png'});
    var param = {
      csrf : csrf
      ,f_id : f_id
      ,param : 'nice'
      ,table : 'forum'
      ,u_id : $(this).data('f_u_id')
    };
    $.post('/forumparamadd/',param,function(){},"json")
    .always(function(res){
      if(res[0]==1){
        csrf = res[1];
        arr_nice[arr_nice.length] = f_id;
        localStorage.nice = JSON.stringify(arr_nice);
      }else{
        $('#f_nice_img_'+f_id).attr({'src': '/assets/img/icon/thumbup_0.png'});
        $('#f_nice_amt_'+f_id).text(amt_nice*1);
      }
      intermittent = true;
    });
  }
});

var arr_certify = localStorage.certify ? JSON.parse(localStorage.certify) : [];
for (var i=0; i<arr_certify.length; i++){
  for (var ii=0; ii<arr_forum.length; ii++){
    if(arr_certify[i] == arr_forum[ii]){
      is_certify = true;
      $('#f_certify_img_'+arr_forum[ii]).attr({'src': '/assets/img/icon/medal_1.png'});
    }
  }
}

var certified = localStorage.certified ? localStorage.certified : 0;
$('.certify').click(function(){
  if(certified > (hour_stamp - 20) ){
    alert(''+ certified - (hour_stamp - 20) + '時間後、可能です。');
    return;
  }
  var is_certify = false;
  var f_id = $(this).data('forum');
  for (var i=0; i<arr_certify.length; i++){
    if( arr_certify[i] == f_id){
      is_certify = true;
    }
  }
  if(!is_certify && intermittent){
    intermittent = false;
    var amt_certify = $('#f_certify_amt_'+f_id ).text();
    $('#f_certify_amt_'+f_id).text(amt_certify*1 + 1);
    $('#f_certify_amt_'+f_id).css({'display': ''});
    $('#f_certify_img_'+f_id).attr({'src': '/assets/img/icon/medal_1.png'});
    var param = {
      csrf : csrf
      ,f_id : f_id
      ,param : 'certify'
      ,table : 'forum'
      ,u_id : $(this).data('f_u_id')
    };
    $.post('/forumparamadd/',param,function(){},"json")
    .always(function(res){
      if(res[0]==1){
        csrf = res[1];
        arr_certify[arr_certify.length] = f_id;
        localStorage.certify = JSON.stringify(arr_certify);
        localStorage.certified = certified = hour_stamp;
      }else{
        $('#f_certify_img_'+f_id).attr({'src': '/assets/img/icon/medal_0.png'});
        $('#f_certify_amt_'+f_id).text(amt_certify*1);
      }
      intermittent = true;
    });
  }
});

//_c = comment
var arr_nice_c = localStorage.nice_c ? JSON.parse(localStorage.nice_c) : [];
for (var i=0; i<arr_nice_c.length; i++){
  for (var ii=0; ii<arr_comment.length; ii++){
    if(arr_nice_c[i] == arr_comment[ii]){
      $('#fc_nice_img_'+arr_comment[ii]).attr({'src': '/assets/img/icon/thumbup_1.png'});
    }
  }
}

$('.nice_c').click(function(){
  var is_nice_c = false;
  var fc_id = $(this).data('comment');
  for (var i=0; i<arr_nice_c.length; i++){
    if( arr_nice_c[i] == fc_id){
      is_nice_c = true;
    }
  }
  if (!is_nice_c) {
    var amt_nice_c = $('#fc_nice_amt_'+fc_id ).text();
    $('#fc_nice_amt_'+fc_id).text(amt_nice_c*1 + 1);
    $('#fc_nice_amt_'+fc_id).css({'display': ''});
    $('#fc_nice_img_'+fc_id).attr({'src': '/assets/img/icon/thumbup_1.png'});
    var param = {
      csrf : csrf
      ,f_id : fc_id
      ,param : 'nice'
      ,table : 'forum_comment'
      ,u_id : $(this).data('fc_u_id')
    };
    $.post('/forumparamadd/',param,function(){},"json")
    .always(function(res){
      if(res[0]==1){
        csrf = res[1];
        arr_nice_c[arr_nice_c.length] = fc_id;
        localStorage.nice_c = JSON.stringify(arr_nice_c);
      }else{
        $('#fc_nice_img_'+fc_id).attr({'src': '/assets/img/icon/thumbup_0.png'});
        $('#fc_nice_amt_'+fc_id).text(amt_nice_c*1);
      }
    });
  }
});

var arr_certify_c = localStorage.certify_c ? JSON.parse(localStorage.certify_c) : [];
for (var i=0; i<arr_certify_c.length; i++){
  for (var ii=0; ii<arr_comment.length; ii++){
    if(arr_certify_c[i] == arr_comment[ii]){
      $('#fc_certify_img_'+arr_comment[ii]).attr({'src': '/assets/img/icon/medal_1.png'});
    }
  }
}

$('.certify_c').click(function(){
  if(certified > (hour_stamp - 20) ){
    alert('only once a day');
    return;
  }
  var is_certify_c = false;
  var fc_id = $(this).data('comment');
  for (var i=0; i<arr_certify_c.length; i++){
    if( arr_certify_c[i] == fc_id){
      is_certify_c = true;
    }
  }
  if (!is_certify_c) {
    var amt_certify_c = $('#fc_certify_amt_'+fc_id ).text();
    $('#fc_certify_amt_'+fc_id).text(amt_certify_c*1 + 1);
    $('#fc_certify_amt_'+fc_id).css({'display': ''});
    $('#fc_certify_img_'+fc_id).attr({'src': '/assets/img/icon/medal_1.png'});
    var param = {
      csrf : csrf
      ,f_id : fc_id
      ,param : 'certify'
      ,table : 'forum_comment'
      ,u_id : $(this).data('fc_u_id')
    };
    $.post('/forumparamadd/',param,function(){},"json")
    .always(function(res){
      if(res[0]==1){
        csrf = res[1];
        arr_certify_c[arr_certify_c.length] = fc_id;
        localStorage.certify_c = JSON.stringify(arr_certify_c);
        localStorage.certified = certified = hour_stamp;
      }else{
        $('#fc_certify_img_'+fc_id).attr({'src': '/assets/img/icon/medal_0.png'});
        $('#fc_certify_amt_'+fc_id).text(amt_certify_c*1);
      }
    });
  }
});


