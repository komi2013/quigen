<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8" />
    <title>translation</title>
    <link rel="shortcut icon" href="/assets/img/icon/quiz_generator.png" />
    <meta name="robots" content="noindex">
    <script src="/third/jquery-2.1.1.min.js"></script>
    <script src="/third/jquery.cookie.js"></script>
    <script src="/third/vue.min.js"></script>
    <script> var ua = '<?=Config::get("my.ua")?>'; </script>
    <script src="/assets/js/analytics_offline.js"></script>
    <link rel="stylesheet" type="text/css" href="/assets/css/basic.css" />
    <link rel="stylesheet" href="/assets/css/pc.css" media="only screen and (min-width : 711px)">
    <link rel="stylesheet" href="/assets/css/sp.css" media="only screen and (max-width : 710px)">
    <meta name="viewport" content="width=device-width, user-scalable=no" >
  </head>
<body>

<?php
  $side = View::forge('side');
  $side->this_page = 'myanswer';
  echo $side;
?>
<div id="content">

<div id="ad"><iframe src="/htm/ad_blank/" width="320" height="50" frameborder="0" scrolling="no"></iframe></div>
<table id="from_text" style="text-align:center;">
<tr><td><input type="text" placeholder="Q." maxlength="300" class="txt_99" id='trans_q'></td></tr>
</table>
<table><tr>
<td class="td_84_t">
    <select name='native' style="width:100%;font-size:20px;">
        <option selected>ja</option>
        <option>ar</option>
        <option>ru</option>
        <option>ko</option>
        <option>es</option>
        <option>zh</option>
        <option>fr</option>
        <option>id</option>
    </select>
</td>
<td>
    <img src="/assets/img/icon/upload_0.png" alt="generate" class="icon" id="generate">
    <img src="/assets/img/icon/success.png" alt="success" class="icon" id="success" style="display:none;">
</td>
</tr></table>
<table id="cel">
    <template v-for="(d,k) in translated">
    <tr v-bind:class="'del_'+k">
        <td colspan="50" class="td_50">{{ d[0] }}</td>
        <td colspan="50" class="td_50">{{ d[1] }}</td>
    </tr>
    <tr v-bind:class="'del_'+k">
        <td colspan="50" class="td_49_t"></td>
        <td colspan="50" class="td_50_t del" v-bind:del_k="k">
            <img src="/assets/img/icon/trash.png" class="icon">
        </td>
    </tr>
    </template>
</table>
</div>
    
<div id="ad_right"></div>
<script>
var domain = '<?=Config::get('my.domain')?>';
var del = '<?=Config::get("lang.delete")?>';
var no_ = '<?=Config::get("lang.no_")?>';
var mon = '<?=Config::get("lang.mon")?>';
var answer_first = '<?=Config::get("lang.answer_first")?>';
var translated = '';
var u_id = '<?=$u_id?>';
var csrf = '<?=Model_Csrf::setcsrf()?>';
</script>
<script src="/assets/js/check_news.js"></script>
<script src="/assets/js/basic_offline.js"></script>
<script src="/assets/js/translation.js"></script>

<script>  
if(navigator.onLine){
  $(function(){ ga('send', 'pageview'); });
}
</script>
</body>
</html>
