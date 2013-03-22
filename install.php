<?php

include 'mysql.php';

$images = array(
    'name' => 15,
);

$rates = array(
    'name' => 15,
    'rate' => 1,
);

$tables = array(
    "images",
    "rates"
);

$db = new mysql();

//$dbname = $db->dbname;

$query;

foreach ($tables as $value) {
    $table = $db->etuliite . $value;
    $query = "";


    $query = "CREATE TABLE IF NOT EXISTS " . $table . "( id INT NOT NULL AUTO_INCREMENT, PRIMARY KEY (id)";

    foreach (${$value} as $key => $value) {
        $query .= ", ";
        $query .= "$key VARCHAR($value)";
    }

    $query .= " )";

    echo $query;

    mysql_query($query)
            or die(mysql_error());
}
?>