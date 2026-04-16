<?php

function fpb($m, $n) {
    while ($n != 0) {
        $kali = floor($m / $n);
        $sisa = $m % $n;

        echo "$m = $kali x $n + $sisa<br>";

        $temp = $n;
        $n = $m % $n;
        $m = $temp;
    }
    return $m;
}

$m = 224;
$n = 324;
$hasilfpb = fpb($m, $n);

if($hasilfpb > 1) {
    echo "FPB dari $m dan $n Adalah relatif prima " . "Karena FPB = " . $hasilfpb;
} else {
    echo "FPB dari $m dan $n Adalah bukan bilangan prima " . "Karena FPB = " . $hasilfpb;
}

?>