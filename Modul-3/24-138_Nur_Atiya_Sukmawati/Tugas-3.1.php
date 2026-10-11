<?php

// Membuat array
$height = array(
    "Andy" => "176",
    "Barry" => "165",
    "Charlie" => "170"
);

// Menambahkan lima data baru
$height["David"] = "180";
$height["Ethan"] = "172";
$height["Frank"] = "168";
$height["George"] = "175";
$height["Harry"] = "182";


// Menampilkan isi array
echo "height = (";

foreach($height as $nama => $tinggi){
    echo '"' . $nama . '"=>"' . $tinggi . '", ';
}

echo ")<br>";


// Mengambil nilai terakhir
foreach($height as $h){
    $terakhir = $h;
}

echo "Nilai dengan indeks terakhir: " . $terakhir;


// Menghapus data Charlie
unset($height["Charlie"]);


echo "<br><br>height = (";

foreach($height as $nama => $tinggi){
    echo '"' . $nama . '"=>"' . $tinggi . '", ';
}

echo ")<br>";


// Mengambil nilai terakhir setelah dihapus
foreach($height as $h){
    $terakhir = $h;
}

echo "Nilai dengan indeks terakhir setelah dihapus: " . $terakhir;

?>