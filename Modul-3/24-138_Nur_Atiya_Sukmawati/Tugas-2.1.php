<?php

// Membuat array awal
$fruits = array("Avocado", "Blueberry", "Cherry");

// Data tambahan
$tambahan = array("Durian", "Watermelon", "Fig", "Grape", "Honeydew");

// Menambahkan data baru menggunakan perulangan for
for($x = 0; $x < 5; $x++){
    $fruits[] = $tambahan[$x];
}

// Menghitung panjang array
$length = count($fruits);

echo "Panjang array saat ini: " . $length;
echo "<br><br>";

// Menampilkan isi array berdasarkan indeks
for($x = 0; $x < $length; $x++){
    echo $fruits[$x];
    echo "<br>";
}

?>