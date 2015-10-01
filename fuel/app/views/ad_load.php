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

<?php }else{ ?>

  <?php if($rand < 7) { ?>
    <iframe src="/htm/ad/?af=adsense_pc" width="320" height="50" frameborder="0" scrolling="no" data-af="adsense_pc" id="ad_frame"></iframe>
    <script> ga('set', 'dimension16', "adsense_pc"); </script>
  <?php } else if($rand < 9) { ?>
    <iframe src="/htm/ad/?af=kauli_pc" width="240" height="60" frameborder="0" scrolling="no" data-af="kauli_pc" id="ad_frame"></iframe>
    <script> ga('set', 'dimension16', "kauli_pc"); </script>
  <?php } else if($rand < 10) { ?>
    <iframe src="/htm/ad/?af=imobile_pc_protrusion" width="468" height="60" frameborder="0" scrolling="no" data-af="imobile_pc_protrusion" id="ad_frame"></iframe>
    <script> ga('set', 'dimension16', "imobile_pc_protrusion"); </script>
  <?php } else if($rand < 11) { ?>
    <iframe src="/htm/ad/?af=imobile_pc_squre" width="200" height="200" frameborder="0" scrolling="no" data-af="imobile_pc_squre" id="ad_frame"></iframe>
    <script> ga('set', 'dimension16', "imobile_pc_squre"); </script>
<?php } } ?>