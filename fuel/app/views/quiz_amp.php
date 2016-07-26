<!DOCTYPE html>
<html amp>
  <head>
    <title><?=$title?></title>
    <meta name="description" content="<?=$q_txt?> <?=$description?>">
    <link rel="shortcut icon" href="/assets/img/icon/quiz_generator.png">
    <link rel="canonical" href="http://<?=Config::get('my.domain').'/quiz/?q='.$question?>" />
    <meta property="og:image" content="http://<?=$img ?: Config::get('my.domain').'/assets/img/icon/qg_big.png'?>" />
    <meta name="viewport" content="width=device-width, user-scalable=no" >
<style amp-custom>
body {
  margin: 0 auto;
  font-size: 15px;
  line-height: 22px;
}
table {
  width: 100%;
  border-collapse: collapse;
}
table td {
  height: 30px;
  border-width: 1px 0px;
  border-color: white;
  border-style: solid;
  table-layout: fixed;
  word-break: break-word;
}
a {
  text-decoration: none;
}
h1 {
  font-size: 15pt;
}
.icon {
  max-height: 48px;
  vertical-align: middle;
  cursor: pointer;
}
#drawer td {
  background-color: #EEEEEE;
  height: 50px;
}
#drawer td.this_page {
  background-color: #FCFCFC;
  border-color: silver;
}
#ad_div {
  text-align: center;
}
.div_right {
  width: 99%;
  text-align: right;
}
.td_15{
  width: 15%;
  text-align:center;
  padding: 10px 0px 10px 5px;
}
.td_15_t{
  width: 15%;
  text-align:center;
  border-bottom: 1px solid #F5F5F5;
  padding: 10px 0px 9px 5px;
}
.td_15_upper{
  width: 15%;
  text-align:center;
  padding: 10px 0px 0px 5px;
}
.td_33{
  width: 33%;
  text-align:center;
  padding-top: 10px;
}
.td_33_t{
  width: 33%;
  text-align:center;
  border-bottom: 1px solid #F5F5F5;
  padding: 0px 0px 19px 0px;
}
.td_34{
  width: 34%;
  text-align:center;
  padding: 10px;
}
.td_42{
  width: 42%;
  text-align:center;
}
.td_49_c{
  background-color: #F5F5F5;
  width: 49%;
  text-align:center;
  padding: 10px;
}
.td_49_t{
  width: 49%;
  text-align:center;
  padding: 0px 10px 19px 10px;
  border-bottom: 1px solid #F5F5F5;
}
.td_50{
  width: 50%;
  text-align:center;
}
.td_50_c{
  background-color: #F5F5F5;
  width: 50%;
  text-align:center;
  padding: 10px;
}
.td_50_t{
  width: 50%;
  text-align:center;
  padding: 0px 10px 19px 10px;
  border-bottom: 1px solid #F5F5F5;
}

.td_68_c{
  background-color: #F5F5F5;
  width: 68%;
  text-align:center;
  padding: 10px;
}
.td_68{
  width: 68%;
  padding: 10px;
}
.td_68_t{
  width: 68%;
  padding: 10px 10px 9px 10px;
  border-bottom: 1px solid #F5F5F5;
}
.td_84{
  width: 84%;
  padding: 10px;
}
.td_84_t{
  width: 84%;
  border-bottom: 1px solid #F5F5F5;
  padding: 20px 10px 19px 10px;
}
.td_84_upper{
  width: 84%;
  padding: 10px 10px 0px 10px;
}
.td_99{
  width: 99%;
  padding: 10px;
  word-break: break-word;
}
.td_99_t{
  width: 99%;
  padding: 20px 10px 19px 10px;
  word-break: break-word;
  border-bottom: 1px solid #F5F5F5;
}
.td_99_box{
  width: 99%;
  padding: 5px 10px 20px 10px;
  word-break: break-word;
  border-bottom: 1px solid #F5F5F5;
}
.td_99_c{
  background-color: #F5F5F5;
  width: 99%;
  text-align: center;
  padding: 10px;
}
.td_99_upper{
  width: 99%;
  padding: 10px 10px 0px 10px;
  word-break: break-word;
} 
.txt_49{
  font-size: 15px;
  height: 48px;
  width: 49%;
}
.txt_80{
  height: 48px;
  width: 80%;
}
.txt_84{
  font-size: 15px;
  height: 48px;
  width: 84%;
}
.txt_99{
  font-size: 15px;
  height: 48px;
  width: 90%;
}
.txt_long{
  height: 90px;
  width: 90%;
  font-size: 15px;
  word-break : break-all;
  padding: 20px 10px 20px 10px;
}
/* /html/news/ */
.edge_click{
  border:solid 1px rgba(0,0,255,0.2);
}
/* /html/news/ */
#imageLoader{
  opacity: 0;
  position: absolute;
  height: 300px;
  width: 300px;
  z-index: 5;
}
.tag_desc{
  font-size: 12px;
  word-wrap: break-word;
  margin: 5px;
}
.anchor{
  color: blue;
  cursor: pointer;
}
.comment_input {
  font-size: 15px;
  height: 48px;
  width: 90%;
  margin: 5px;
}

#header td {
  width: 20%;
  text-align: center;
  background-color: #EEEEEE;
}

#header td.this_page {
  background-color: #FCFCFC;
  border-color: silver;
}

.img_input {
  width: 100%;
  text-align: center;
}

.input_with {
  width: 60%;
  display: inline-block;
  height: 45px;
  font-size:18px;
  border-width: 1px;
}
#news_num {
  position: absolute;
  background-color: yellow;
  color: black;
  border-radius: 12px;
  width: 24px;
  height: 24px;
  line-height: 24px;
  text-align: center;
  display: none;
}
.txt_long_60 {
  height: 60px;
  width: 90%;
  font-size: 15px;
  word-break : break-all;
}
#mycanvas1 {
  position: absolute;
  top: -10000px;
  left: -150px;
}
#file_load {
  opacity: 0;
  position: absolute;
  height: 48px;
  width: 48px;
  z-index: 5;
}
.td_99_icon{
  background-color: #F5F5F5;
  width: 99%;
  text-align: center;
}
.choice{
  background-color: #F5F5F5;
  width: 99%;
  cursor: pointer;
  padding: 10px;
  height:30px;
}
#photo{
  max-height: 300px;
  max-width: 300px;
}
#div_photo{
  text-align: center;
  width:99%;
}
.ans_u_correct{
  height: 50px;
  width: 12%;
  text-align: center;
  background-color: rgba(0,255,0,0.2);
  border-width: 0px 0px;
}
.ans_u_incorrect{
  height: 50px;
  width: 12.5%;
  text-align: center;
  background-color: rgba(255,0,0,0.2);
  border-width: 0px 0px;
}
.ans_icon{
  max-width: 35px;
  text-align: center;
}
#big_result{
  position: relative;
}
.big_icon{
  position: absolute;
  top: -60px;
  left: 10px;
  height: 300px;
  z-index: 3;
  opacity: 0.6;
}
.font_8 {
  font-size: 8pt;
}
#center {
  font-size: 13pt;
}
#drawer {
  width: 80%;
  overflow: scroll;
  position: absolute;
  z-index: 10;
  margin: 0;
  background-color: white;
  left: -100%;
  top : 51px;
  float: left;
}
.sp_disp_none{
  display: none;
}
.choice a {
  position: absolute;
  width: 100%;
  display: block;
  height: 100%;
}
</style>
<script async src="https://cdn.ampproject.org/v0.js"></script>
<script async custom-element="amp-analytics" src="https://cdn.ampproject.org/v0/amp-analytics-0.1.js"></script>
<script async custom-element="amp-iframe" src="https://cdn.ampproject.org/v0/amp-iframe-0.1.js"></script>
<script async custom-element="amp-youtube" src="https://cdn.ampproject.org/v0/amp-youtube-0.1.js"></script>
<script async custom-element="amp-twitter" src="https://cdn.ampproject.org/v0/amp-twitter-0.1.js"></script>
<script async custom-element="amp-instagram" src="https://cdn.ampproject.org/v0/amp-instagram-0.1.js"></script>
<script async custom-element="amp-facebook" src="https://cdn.ampproject.org/v0/amp-facebook-0.1.js"></script> 
  </head>
<body>


<amp-analytics type="googleanalytics" id="ldnews_analytics">
<script type="application/json">
{
  "vars": {
    "account": "<?=Config::get("my.ua")?>"
  },
  "triggers": {
    "defaultPageview": {
      "on": "visible",
      "request": "pageview"
    }
  }
}
</script>
</amp-analytics>

<div id="content">

<?php if($img){?>
<div id="div_photo">
<amp-img src="<?=$img?>" alt="quiz photo" id="photo"></amp-img>
</div>
<?php } ?>
<table><tr>
  <td id="question" class="td_99_box"><?=$q_txt?></td>
</tr></table>
<div id="big_result">

<table>
  <tr><td class="choice" id="choice_0"><a href="/quiz/?q=<?=$question?>"><?=$arr_choice[0]?></a></td></tr>
  <tr><td class="choice" id="choice_1"><a href="/quiz/?q=<?=$question?>"><?=$arr_choice[1]?></a></td></tr>
  <tr><td class="choice" id="choice_2"><a href="/quiz/?q=<?=$question?>"><?=$arr_choice[2]?></a></td></tr>
  <tr><td class="choice" id="choice_3"><a href="/quiz/?q=<?=$question?>"><?=$arr_choice[3]?></a></td></tr>
</table>
</div>

<table>
<tr>
<?php $i=0; while($i<16){ ?>
  <?php if($i == 8){ ?>
    </tr><tr>
  <?php } ?>
  <td id="co_<?=$i?>" class="ans_u_correct"></td>
<?php ++$i;} ?>
</tr>
</table>

<table>
<tr>
<?php $i=0; while($i<16){ ?>
  <?php if($i == 8){ ?>
    </tr><tr>
  <?php } ?>
  <td id="inco_<?=$i?>" class="ans_u_incorrect"></td>
<?php ++$i;} ?>
</tr>
</table>

<span id="generator"></span> <span id="tag"></span>
<br>
<?php foreach ($arr_comment as $d) { ?>
  <div class="comment"><?=$d['txt']?></div>
<?php } ?>


<?php if($reference){ ?> 
<div >reference:<?=$reference?></div>
<?php } ?>
<table id="next_prev"></table>

<div >
  <a href="#" id="report">
    <amp-img src="/assets/img/icon/exclamation.png"></amp-img>
  </a>
</div>

<table >
<tr><td colspan="2" class="td_98">buy this quiz</td></tr>
<tr>
<td class="td_32">
  <a href="#" id="20pt">20 pt</a>
</td>
<td class="td_32">
  <a href="#" id="0pt">0 pt</a>
</td>
</tr>
</table>


</div>
<div id="correct" ><?=$correct?></div>

</body>
</html>

