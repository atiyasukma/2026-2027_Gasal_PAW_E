<?php

// Membuat array
$weight = array(
    "Andy" => "70",
    "Barry" => "65",
    "Charlie" => "75"
);



// Menampilkan isi array
echo "weight = (";

foreach($weight as $nama => $berat){
    echo '"' . $nama . '"=>"' . $berat . '", ';
}

echo ")<br>";


// Mengambil data kedua
$data = array_values($weight);
echo "Data kedua: " . $data[1];

?>