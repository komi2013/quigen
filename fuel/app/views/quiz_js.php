var choice_0 = '<?=$arr_choice[0]?>';
var choice_1 = '<?=$arr_choice[1]?>';
var choice_2 = '<?=$arr_choice[2]?>';
var choice_3 = '<?=$arr_choice[3]?>';
var append = '<div style="position: relative;">'+
  '<img src="<?=Config::get('my.domain')?>" alt="correct" id="big_correct" style="display:none;position: absolute;top: -60px;left: 10px;height: 300px;z-index: 3;opacity: 0.6;">'+
  '<img src="<?=Config::get('my.domain')?>" alt="incorrect" id="big_incorrect" style="display:none;position: absolute;top: -60px;left: 10px;height: 300px;z-index: 3;opacity: 0.6;">'+
  '<div><?=$q_txt?></div>'+
  '<div onClick="choice(this)" style="background-color:#F5F5F5;cursor:pointer;">'+choice_0+'</div>'+
  '<div onClick="choice(this)" style="background-color:white;cursor:pointer;">'+choice_1+'</div>'+
  '<div onClick="choice(this)" style="background-color:#F5F5F5;cursor:pointer;">'+choice_2+'</div>'+
  '<div onClick="choice(this)" style="background-color:white;cursor:pointer;">'+choice_3+'</div>'+
  '</div>';
document.getElementById('quigen').innerHTML = append;
function choice(this_result){
  console.log(this_result.innerHTML);
  if(this_result.innerHTML == '<?=$correct?>'){
    document.getElementById('big_correct').style.display = '';
  }else{
    document.getElementById('big_incorrect').style.display = '';
  }
}