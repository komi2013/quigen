<style> * {  margin: 0 auto; padding: 0;} </style>
<?php switch ($_GET['af']) { ?>
<?php case 'imobile_sp': ?>
  <!-- i-mobile for SmartPhone client script -->
  <script type="text/javascript">
    imobile_tag_ver = "0.2"; 
    imobile_pid = "36795"; 
    imobile_asid = "382378"; 
    imobile_type = "inline";
  </script>
  <script type="text/javascript" src="http://spad.i-mobile.co.jp/script/adssp.js?20110215"></script>
<?php break; ?>

<?php case 'kauli_sp': ?>
  <script type="text/javascript">var kauli_yad_js_count = typeof(kauli_yad_js_count) == 'undefined' ? 1 : kauli_yad_js_count + 1;
  (function(d){ d.write('<span id="kauli_yad_js_' + kauli_yad_js_count + '" style="width:320px; height:50px; display:inline-block"><' + '!--62560--' + '>');
  var src = 'http://js.kau.li/ssp.js?count=' + kauli_yad_js_count; d.write('<scr' + 'ipt type="text/javascript" src="' + src + '"></scr' + 'ipt>');
  d.write('</span>');})(document);</script>
<?php break; ?>

<?php case 'nend_sp': ?>
  <script type="text/javascript">
    var nend_params = {"media":23092,"site":118190,"spot":309354,"type":1,"oriented":1};
  </script>
  <script type="text/javascript" src="http://js1.nend.net/js/nendAdLoader.js"></script>
<?php break; ?>

<?php case 'imobile_pc_squre': ?>
  <script type="text/javascript">
    imobile_pid = "36795"; 
    imobile_asid = "382708"; 
    imobile_width = 200; 
    imobile_height = 200;
  </script>
  <script type="text/javascript" src="http://spdeliver.i-mobile.co.jp/script/ads.js?20101001"></script>
<?php break; ?>

<?php case 'imobile_pc_protrusion': ?>
  <script type="text/javascript">
    imobile_pid = "36795"; 
    imobile_asid = "382710"; 
    imobile_width = 468; 
    imobile_height = 60;
  </script>
  <script type="text/javascript" src="http://spdeliver.i-mobile.co.jp/script/ads.js?20101001"></script>
<?php break; ?>
<?php case 'kauli_pc': ?>

  <script type="text/javascript">
  var kauli_yad_js_count = typeof(kauli_yad_js_count) == 'undefined' ? 1 : kauli_yad_js_count + 1;
  (function(d){ d.write(
    '<span id="kauli_yad_js_' + kauli_yad_js_count + '" style="width:234px; height:60px; display:inline-block"><' + '!--62561--' + '>');
  var src = 'http://js.kau.li/ssp.js?count=' + kauli_yad_js_count;
  d.write('<scr' + 'ipt type="text/javascript" src="' + src + '"></scr' + 'ipt>'); d.write('</span>');})(document);
  </script>
<?php break; ?>

<?php case 'adsense_sp': ?>
<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- 320*50のバナー -->
<ins class="adsbygoogle"
     style="display:inline-block;width:320px;height:50px"
     data-ad-client="ca-pub-1763935619573577"
     data-ad-slot="5966804842"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>
<?php break; ?>

<?php case 'adsense_pc': ?>
<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- 320*50のバナー -->
<ins class="adsbygoogle"
     style="display:inline-block;width:320px;height:50px"
     data-ad-client="ca-pub-1763935619573577"
     data-ad-slot="5966804842"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>
<?php break; ?>

<?php }?>

