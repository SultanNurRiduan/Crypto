<?php
$hariList = ["Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu", "Minggu"];

$hariAwal = "Selasa";
$jamAwal = 9;
$durasi = 50;
$m = 24;

// cari index hari awal
$indexHariAwal = array_search($hariAwal, $hariList);

// total jam
$totalJam = $jamAwal + $durasi;

// hitung jam akhir
$jamAkhir = $totalJam % $m;

// hitung tambahan hari
$hariTambahan = intdiv($totalJam, $m);

// hitung hari akhir
$indexHariAkhir = ($indexHariAwal + $hariTambahan) % 7;
$hariAkhir = $hariList[$indexHariAkhir];

echo "Hari awal: $hariAwal<br>";
echo "Jam awal: $jamAwal<br>";
echo "Durasi: $durasi jam<br>";
echo "Jam akhir: $jamAkhir<br>";
echo "Hari akhir: $hariAkhir<br>";
?>