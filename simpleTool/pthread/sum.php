<?php
$total = 0;
 
$startTime = microtime(true);
 
for($ix = 0; $ix < 10000000; ++$ix) {
    $total += $ix;
}
 
$endTime = microtime(true);
$time = $endTime - $startTime;
 
echo "total : {$total} time : {$time} \r\n";