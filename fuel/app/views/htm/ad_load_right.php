<style>
/*#ad_frame_right {
  left: 730px;
  top: 70px;
  position: absolute;
}
*/
</style>
<?php
$rand = rand(1,10);

if( Model_Util::is_mobile() != 1){

  if($rand < 7) { ?>
    <iframe src="/htm/ad_right/?af=adsense_pc_right" width="160" height="600" frameborder="0" scrolling="no" data-af="adsense_pc_right" id="ad_frame_right"></iframe>
    <script> ga('set', 'dimension16', "adsense_pc_right"); </script>
  <?php } else if($rand < 9) { ?>
    <iframe src="/htm/ad_right/?af=kauli_pc_right" width="160" height="600" frameborder="0" scrolling="no" data-af="kauli_pc_right" id="ad_frame_right"></iframe>
    <script> ga('set', 'dimension16', "kauli_pc_right"); </script>
  <?php } else if($rand < 11) { ?>
    <iframe src="/htm/ad_right/?af=imobile_pc_right" width="160" height="600" frameborder="0" scrolling="no" data-af="imobile_pc_right" id="ad_frame_right"></iframe>
    <script> ga('set', 'dimension16', "imobile_pc_right"); </script>
  <?php } ?>

<?php } ?>