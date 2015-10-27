<?php
$rand = rand(1,10);
if( Model_Util::is_mobile() == 1){

  if($rand < 7) { ?>
    <iframe src="/htm/ad_menu/?af=adsense_sp_menu" width="300" height="250" frameborder="0" scrolling="no" class="ad_frame"></iframe>
    <script> ga('set', 'dimension16', "adsense_sp_menu"); </script>
  <?php } else if($rand < 9) { ?>
    <iframe src="/htm/ad_menu/?af=nend_sp_menu" width="300" height="250" frameborder="0" scrolling="no" class="ad_frame"></iframe>
    <script> ga('set', 'dimension16', "nend_sp_menu"); </script>
  <?php } else if($rand < 10) { ?>
    <iframe src="/htm/ad_menu/?af=kauli_sp_menu" width="300" height="250" frameborder="0" scrolling="no" class="ad_frame"></iframe>
    <script> ga('set', 'dimension16', "kauli_sp_menu"); </script>
  <?php } else if($rand < 11) { ?>
    <iframe src="/htm/ad_menu/?af=imobile_sp_menu" width="300" height="250" frameborder="0" scrolling="no" class="ad_frame"></iframe>
    <script> ga('set', 'dimension16', "imobile_sp_menu"); </script>
  <?php } ?>

<?php }else{ ?>

  <?php if($rand < 7) { ?>
    <iframe src="/htm/ad_menu/?af=adsense_pc_menu" width="300" height="250" frameborder="0" scrolling="no" class="ad_frame"></iframe>
    <script> ga('set', 'dimension16', "adsense_pc_menu"); </script>
  <?php } else if($rand < 9) { ?>
    <iframe src="/htm/ad_menu/?af=kauli_pc_menu" width="300" height="250" frameborder="0" scrolling="no" class="ad_frame"></iframe>
    <script> ga('set', 'dimension16', "kauli_pc_menu"); </script>
  <?php } else if($rand < 11) { ?>
    <iframe src="/htm/ad_menu/?af=imobile_pc_menu" width="300" height="250" frameborder="0" scrolling="no" class="ad_frame"></iframe>
    <script> ga('set', 'dimension16', "imobile_pc_menu"); </script>
  <?php } ?>

<?php } ?>