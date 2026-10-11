<?php

$weight = array(
    "Andy" => "70",
    "Barry" => "65",
    "Charlie" => "75"
);

$key = array_keys($weight);

echo 'weight = (';

for($x = 0; $x < count($weight); $x++){
    echo '"' . $key[$x] . '"=>"' . $weight[$key[$x]] . '", ';
}

echo ")<br><br>";

for($x = 0; $x < count($weight); $x++){
    echo $key[$x] . " is " . $weight[$key[$x]] . " kg.<br>";
}

?>