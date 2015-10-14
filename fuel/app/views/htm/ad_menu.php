<style> * {  margin: 0 auto; padding: 0;} </style>
<?php switch ($_GET['af']) { ?>
<?php case 'adsense_pc_menu': ?>
  <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
  <!-- スクエア -->
  <ins class="adsbygoogle"
       style="display:inline-block;width:250px;height:250px"
       data-ad-client="ca-pub-1763935619573577"
       data-ad-slot="4458425244"></ins>
  <script>
  (adsbygoogle = window.adsbygoogle || []).push({});
  </script>
<?php break; ?>

<?php case 'kauli_pc_menu': ?>
  <script type="text/javascript">var kauli_yad_js_count = typeof(kauli_yad_js_count) == 'undefined' ? 1 : kauli_yad_js_count + 1;
  (function(d){ d.write('<span id="kauli_yad_js_' + kauli_yad_js_count + '" style="width:250px; height:250px; display:inline-block"><' + '!--68407--' + '>');
  var src = 'http://js.kau.li/ssp.js?count=' + kauli_yad_js_count; d.write('<scr' + 'ipt type="text/javascript" src="' + src + '"></scr' + 'ipt>'); d.write('</span>');})(document);</script>
<?php break; ?>

<?php case 'imobile_pc_menu': ?>
  <!-- i-mobile for PC client script -->
  <script type="text/javascript">
          imobile_pid = "36795"; 
          imobile_asid = "611760"; 
          imobile_width = 250; 
          imobile_height = 250;
  </script>
  <script type="text/javascript" src="http://spdeliver.i-mobile.co.jp/script/ads.js?20101001"></script>
<?php break; ?>

<?php }?>