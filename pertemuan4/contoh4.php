<?php
$bil1 = 100;
$bil2 = 20;
$teks1 = "PHP";
$teks2 = "php";

$hasil = ($bil1 <> $bil2) or ($teks1 == $teks2);
echo "($bil1 <> $bil2) or ($teks1 == $teks2) : $hasil<br>";

$hasil = !($bil1 <> $bil2) and ($teks1 == $teks2);
echo "!($bil1 <> $bil2) and ($teks1 == $teks2) : $hasil<br>";
