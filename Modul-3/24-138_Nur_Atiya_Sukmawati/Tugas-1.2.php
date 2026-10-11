<?php

$fruits = array(
    "Avocado",
    "Blueberry",
    "Cherry",
    "Durian",
    "Elderberry",
    "Fig",
    "Grape",
    "Honeydew"
);

// menghapus Blueberry
unset($fruits[1]);

// merapikan indeks
$fruits = array_values($fruits);

echo "Data Blueberry dihapus.<br>";

echo "fruits = (";

foreach($fruits as $f){
    echo '"' . $f . '", ';
}

echo ")<br>";

$jumlahdata = count($fruits);
echo "Nilai dengan indeks tertinggi: " . $fruits[$jumlahdata-1];

?>