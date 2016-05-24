if(navigator.onLine){
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  if($.cookie('ua_u_id')){
    localStorage.ua_u_id = $.cookie('ua_u_id');
    $.cookie('ua_u_id','',{expires:-1,path:'/'});  
  }
  if(localStorage.ua_u_id){
    ga('create',ua,'auto',{'userId':'u_'+localStorage.ua_u_id,'allowLinker': true});
    ga('set','dimension2',localStorage.ua_u_id);
  }else{
    ga('create',ua,'auto',{'allowLinker': true});
  }

  if(!$.cookie('ab_test')){
    $.cookie('ab_test',parseInt(Math.random()*10),{expires:730,path:'/'}); 
  }
  ga('set', 'dimension4', 'ab_'+$.cookie('ab_test'));

  ga('require', 'displayfeatures');
  ga('require', 'linker');
  ga('linker:autoLink', ['quizgenerator.hatenablog.com']);
}

var getUrlVars = function(){
  var vars = {}; 
  var param = location.search.substring(1).split('&');
  for(var i = 0; i < param.length; i++) {
    var keySearch = param[i].search(/=/);
    var key = '';
    if(keySearch != -1) key = param[i].slice(0, keySearch);
    var val = param[i].slice(param[i].indexOf('=', 0) + 1);
    if(key != '') vars[key] = decodeURI(val);
  }
  return vars; 
}
var getVal = getUrlVars();