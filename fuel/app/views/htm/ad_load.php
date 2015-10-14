<?php
$rand = rand(1,10);
if( Model_Util::is_mobile() == 1){

  if($rand < 7) { ?>
    <iframe src="/htm/ad/?af=adsense_sp" width="320" height="50" frameborder="0" scrolling="no" data-af="adsense_sp" id="ad_frame"></iframe>
    <script> ga('set', 'dimension16', "adsense_sp"); </script>
  <?php } else if($rand < 9) { ?>
    <iframe src="/htm/ad/?af=nend_sp" width="320" height="50" frameborder="0" scrolling="no" data-af="nend_sp" id="ad_frame"></iframe>
    <script> ga('set', 'dimension16', "nend_sp"); </script>
  <?php } else if($rand < 10) { ?>
    <iframe src="/htm/ad/?af=kauli_sp" width="320" height="50" frameborder="0" scrolling="no" data-af="kauli_sp" id="ad_frame"></iframe>
    <script> ga('set', 'dimension16', "kauli_sp"); </script>
  <?php } else if($rand < 11) { ?>
    <iframe src="/htm/ad/?af=imobile_sp" width="320" height="50" frameborder="0" scrolling="no" data-af="imobile_sp" id="ad_frame"></iframe>
    <script> ga('set', 'dimension16', "imobile_sp"); </script>
  <?php } ?>

<?php } ?>