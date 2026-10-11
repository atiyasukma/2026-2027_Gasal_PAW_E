<?php

$fruits = array("Avocado", "Blueberry", "Cherry");

// menambahkan lima data baru
$fruits[] = "Durian";
$fruits[] = "Elderberry";
$fruits[] = "Fig";
$fruits[] = "Grape";
$fruits[] = "Honeydew";

echo "fruits = (";

foreach($fruits as $f){
    echo '"' . $f . '", ';
}

echo ")<br>";

$jumlahdata = count($fruits);
echo "Nilai dengan indeks tertinggi: " . $fruits[$jumlahdata-1];

?>