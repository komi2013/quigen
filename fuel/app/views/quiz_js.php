var choice_0 = '<?=$arr_choice[0]?>';
var choice_1 = '<?=$arr_choice[1]?>';
var choice_2 = '<?=$arr_choice[2]?>';
var choice_3 = '<?=$arr_choice[3]?>';
var append = '<div style="position: relative;">'+
  '<img src="http://<?=Config::get('my.domain')?>/assets/img/icon/circle_big.png" alt="correct" id="big_correct_<?=$div_id?>" style="display:none;position: absolute;top: 10px;left: 10px;max-width: 150px;max-height: 200px;z-index: 3;opacity: 0.6;">'+
  '<img src="http://<?=Config::get('my.domain')?>/assets/img/icon/cross_big.png" alt="incorrect" id="big_incorrect_<?=$div_id?>" style="display:none;position: absolute;top: 10px;left: 10px;max-width: 150px;max-height: 200px;z-index: 3;opacity: 0.6;">'+
  '<div><?=$q_txt?></div>'+
  '<div onClick="choice_<?=$div_id?>(this)" style="background-color:#F5F5F5;cursor:pointer;">'+choice_0+'</div>'+
  '<div onClick="choice_<?=$div_id?>(this)" style="background-color:white;cursor:pointer;">'+choice_1+'</div>'+
  '<div onClick="choice_<?=$div_id?>(this)" style="background-color:#F5F5F5;cursor:pointer;">'+choice_2+'</div>'+
  '<div onClick="choice_<?=$div_id?>(this)" style="background-color:white;cursor:pointer;">'+choice_3+'</div>'+
  '<div id="ad_link_<?=$div_id?>" style="display:none;"><a href="http://<?=Config::get('my.domain')?>/">引き続きクイズを答える</a></div>'+
  '</div>';
document.getElementById('<?=$div_id?>').innerHTML = append;
function choice_<?=$div_id?>(this_result){
  document.getElementById('ad_link_<?=$div_id?>').style.display = '';
  if(this_result.innerHTML == '<?=$correct?>'){
    document.getElementById('big_incorrect_<?=$div_id?>').style.display = 'none';
    document.getElementById('big_correct_<?=$div_id?>').style.display = '';
  }else{
    document.getElementById('big_correct_<?=$div_id?>').style.display = 'none';
    document.getElementById('big_incorrect_<?=$div_id?>').style.display = '';
  }
}