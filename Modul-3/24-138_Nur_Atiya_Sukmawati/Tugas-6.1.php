<?php

// 1. array_push
$arr_push = ["A"];
echo "Array awal: (\"A\")<br>";
array_push($arr_push, "B");
echo "Hasil array_push: ";
foreach ($arr_push as $item) {
    echo $item . " ";
}
echo "<br><br>";

// 2. array_merge
$arr_merge1 = ["A", "B"];
$arr_merge2 = ["C"];
echo "Array awal: (\"A\", \"B\") digabung dengan (\"C\")<br>";
$res_merge = array_merge($arr_merge1, $arr_merge2);
echo "Hasil array_merge: ";
foreach ($res_merge as $item) {
    echo $item . " ";
}
echo "<br><br>";

// 3. array_values
$arr_assoc = ["x" => 1, "y" => 2];
echo "Array awal: (\"x\" => 1, \"y\" => 2)<br>";
$res_values = array_values($arr_assoc);
echo "Hasil array_values: ";
foreach ($res_values as $val) {
    echo $val . " ";
}
echo "<br><br>";

// 4. array_search
$arr_search = ["A", "B", "C"];
echo "Mencari \"B\" pada array: (\"A\", \"B\", \"C\")<br>";
$res_search = array_search("B", $arr_search);
echo "Hasil array_search: " . $res_search . "<br><br>";

// 5. array_filter
$arr_filter = [0, 1, false, 2, "", 3, "array"];
echo "Array awal: (0, 1, false, 2, \"\", 3, \"array\")<br>";
$res_filter = array_filter($arr_filter);
echo "Hasil array_filter: ";
foreach ($res_filter as $item) {
    echo $item . " ";
}
echo "<br><br>";

// 6. sort & rsort
$arr_num = [3, 1, 2];
echo "Array awal: (3, 1, 2)<br>";

$arr_sort = $arr_num;
sort($arr_sort);
echo "Hasil sort: ";
foreach ($arr_sort as $val) {
    echo $val . " ";
}
echo "<br>";

$arr_rsort = $arr_num;
rsort($arr_rsort);
echo "Hasil rsort: ";
foreach ($arr_rsort as $val) {
    echo $val . " ";
}
echo "<br><br>";

// 7. asort, ksort, arsort, krsort
$arr_age = ["Peter" => 35, "Ben" => 37, "Joe" => 43];
echo "Array awal: (\"Peter\"=>35, \"Ben\"=>37, \"Joe\"=>43)<br>";

// Fungsi bantuan cetak format asosiatif tanpa implode()
function printAssoc($arr) {
    $first = true;
    foreach ($arr as $key => $val) {
        if (!$first) {
            echo ", ";
        }
        echo "$key=> $val";
        $first = false;
    }
}

$arr_asort = $arr_age;
asort($arr_asort);
echo "Hasil asort: ";
printAssoc($arr_asort);
echo "<br>";

$arr_ksort = $arr_age;
ksort($arr_ksort);
echo "Hasil ksort: ";
printAssoc($arr_ksort);
echo "<br>";

$arr_arsort = $arr_age;
arsort($arr_arsort);
echo "Hasil arsort: ";
printAssoc($arr_arsort);
echo "<br>";

$arr_krsort = $arr_age;
krsort($arr_krsort);
echo "Hasil krsort: ";
printAssoc($arr_krsort);
echo "<br>";

?>