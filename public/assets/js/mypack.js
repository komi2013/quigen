$('#generate').click(function(){
  if(!u_id){
    alert('はじめにクイズに答えてください');
    return;
  }
  var validate = 1;
  if($('#q_txt').val()==''){
    $('#q_txt').css({'border-color':'red'});
    validate=2;
  }
  for(i = 1; i < 5; i++){
    if($('#choice_'+i).val()==''){
      $('#choice_'+i).css({'border-color':'red'});
      validate=2;
    }
  }
  if(validate==2){
    return;
  }
  
  if(q_amt > 18){
    r = confirm('この後、修正できません。いいですか？');
    if(r){
      generate();
    }
  }else{
    generate();
  }
  
});
function generate(){
  if(!u_id){
    alert('はじめにクイズに答えてください');
    return;
  }
  var mycanvas = document.getElementById('mycanvas');
  if(change_pic == 1){
    var imgdata = mycanvas.toDataURL();
  }else{
    var imgdata = 'no';
  }
  $('#generate').css({'display': 'none'});
  $('#success').css({'display':''});
  var param = {
    csrf : csrf
    ,pack_id : pack_id
    ,pack_txt : pack_txt
    ,q_txt : $('#q_txt').val()
    ,choice_0 : $('#choice_0').val()
    ,choice_1 : $('#choice_1').val()
    ,choice_2 : $('#choice_2').val()
    ,choice_3 : $('#choice_3').val()
    ,img : imgdata
    ,q_amt : q_amt
  };
  $.post('/paidquizadd/',param,function(){},"json")
  .always(function(res){
    if(res[0]==1){
      location.reload(true);
    }else{
      $('#success').css({'display':'none'});
      $('#generate').css({'display': ''});
      alert('connection error');
    }
  });
//  ga('set', 'dimension3',localStorage.genestep);
  ga('send','event','generate','upload',localStorage.genestep,1);
}

//.begin. canvas edit
var resImg = document.getElementById('mycanvas');
var gesturableImg = new ImgTouchCanvas({
    canvas: resImg,
    path: "/assets/img/icon/camera.png"
});

var imageLoader = document.getElementById('imageLoader');
    imageLoader.addEventListener('change', handleImage, false);
var change_pic = 0;
function handleImage(e){
    $('#imageLoader').css({
      'display': 'none'
    });
    var reader = new FileReader();
    reader.onload = function(event){
      var img = new Image();
      img.src = event.target.result;
      var gesturableImg = new ImgTouchCanvas({
        canvas: document.getElementById('mycanvas')
        ,path: img.src
        ,desktop: true
      });
      change_pic = 1;
    }
    reader.readAsDataURL(e.target.files[0]);     
}
//.end. canvas edit

$('#rotate').click(function(){
  var canvas = document.getElementById('mycanvas');
  var ctx = canvas.getContext('2d');
  var image = new Image();
  image.src = canvas.toDataURL();
  var rad = Math.atan2(1, 0);
  ctx.save();
  var image_width  = 300;
  var image_height = 300;
  ctx.translate(150, 150);
  ctx.rotate(rad);
  ctx.translate(-150, -150);
  ctx.drawImage(image,0,0);
  if(change_pic == 1){
    gesturableImg.rotate = gesturableImg.rotate + 1;
  }
    
});

$('#delete').click(function(){
  r = confirm('削除します');
  if(r){
    var quiz_id=[];
    $('[name="pack_id"]:checked').each(function(){
      quiz_id.push($(this).val());
    });
    var param = {
      csrf : csrf
      ,pack_id : pack_id
    };
    $.post('/myquizdelete/',param,function(res){
      if(res[0]==1){
        location.href='';
      }
    }, "json");  
  }
});

             
