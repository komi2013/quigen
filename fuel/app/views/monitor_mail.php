
<?php foreach($count as $d){ ?>
  <?=str_pad($d['relname'],20,' ')?>,<?=str_pad($d['rowcount'],6)." \r"?>
<?php } ?>
              -----------------------------
number of httpd                     ,<?=str_pad($arr_httpd[0],6)?>, <?=$arr_httpd[1]." \r"?>
number of db                        ,<?=str_pad($arr_db[0],6)?>, <?=$arr_db[1]." \r"?>
used disk GB max 195GB              ,<?=str_pad($arr_disk[0],6)?>, <?=$arr_disk[1]." \r"?>
vmstat (r) read                     ,<?=str_pad($arr_read[0],6)?>, <?=$arr_read[1]." \r"?>
vmstat (w) write                    ,<?=str_pad($arr_write[0],6)?>, <?=$arr_write[1]." \r"?>
vmstat (free+buff+cache) MB freemem ,<?=str_pad($arr_freemem[0],6)?>, <?=$arr_freemem[1]." \r"?>
vmstat(us + sy) cpu                 ,<?=str_pad($arr_cpu[0],6)?>, <?=$arr_cpu[1]." \r"?>
              -----------------------------
<?=$err_log?>
