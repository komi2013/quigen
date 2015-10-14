<style>
#ad_frame_bottom {
  bottom: -60px;
  left: 310px;
  position: absolute;
  
}
</style>
<?php
$rand = rand(1,10);
if( Model_Util::is_mobile() != 1){

  if($rand < 7) { ?>
    <iframe src="/htm/ad_bottom/?af=adsense_pc_bottom" width="468" height="60" frameborder="0" scrolling="no" data-af="adsense_pc_bottom" id="ad_frame_bottom"></iframe>
    <script> ga('set', 'dimension16', "adsense_pc_bottom"); </script>
  <?php } else if($rand < 9) { ?>
    <iframe src="/htm/ad_bottom/?af=kauli_pc_bottom" width="468" height="60" frameborder="0" scrolling="no" data-af="kauli_pc_bottom" id="ad_frame_bottom"></iframe>
    <script> ga('set', 'dimension16', "kauli_pc_bottom"); </script>
  <?php } else if($rand < 11) { ?>
    <iframe src="/htm/ad_bottom/?af=imobile_pc_bottom" width="468" height="60" frameborder="0" scrolling="no" data-af="imobile_pc_bottom" id="ad_frame_bottom"></iframe>
    <script> ga('set', 'dimension16', "imobile_pc_bottom"); </script>
  <?php } ?>

<?php } ?>