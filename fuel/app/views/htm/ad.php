<!DOCTYPE html>
<html>
  <head>
  <meta charset="UTF-8" />
  <meta name="robots" content="noindex,nofollow">
  </head>
<body>
<style> * {  margin: 0 auto; padding: 0;} </style>
<?php if( !isset($_GET['af']) ) { die(View::forge('404')); } ?>
<?php switch ($_GET['af']) { ?>
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

<?php case 'nend_sp': ?>
  <script type="text/javascript">
    var nend_params = {"media":23092,"site":118190,"spot":309354,"type":1,"oriented":1};
  </script>
  <script type="text/javascript" src="http://js1.nend.net/js/nendAdLoader.js"></script>
<?php break; ?>

<?php case 'adsense_pc': ?>
  <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
  <!-- レクタングル -->
  <ins class="adsbygoogle"
       style="display:inline-block;width:300px;height:250px"
       data-ad-client="ca-pub-1763935619573577"
       data-ad-slot="3701545641"></ins>
  <script>
  (adsbygoogle = window.adsbygoogle || []).push({});
  </script>
<?php break; ?>

<?php case 'kauli_pc': ?>
  <script type="text/javascript">var kauli_yad_js_count = typeof(kauli_yad_js_count) == 'undefined' ? 1 : kauli_yad_js_count + 1;
  (function(d){ d.write('<span id="kauli_yad_js_' + kauli_yad_js_count + '" style="width:300px; height:250px; display:inline-block"><' + '!--68412--' + '>');
  var src = 'http://js.kau.li/ssp.js?count=' + kauli_yad_js_count; d.write('<scr' + 'ipt type="text/javascript" src="' + src + '"></scr' + 'ipt>'); d.write('</span>');})(document);</script>
<?php break; ?>

<?php case 'imobile_pc': ?>
  <!-- i-mobile for PC client script -->
  <script type="text/javascript">
          imobile_pid = "36795"; 
          imobile_asid = "612336"; 
          imobile_width = 300; 
          imobile_height = 250;
  </script>
  <script type="text/javascript" src="http://spdeliver.i-mobile.co.jp/script/ads.js?20101001"></script>
<?php break; ?>

<?php }?>

</body>
</html>