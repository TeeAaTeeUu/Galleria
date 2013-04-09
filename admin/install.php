<?php

include 'classes/mysql.php';

$images = array(
    'name' => 50,
);

$infos = array(
    'name' => 50,
    'nimi' => 75,
    'nick' => 50,
    'kenen' => 50,
);

$comments = array(
    'name' => 50,
    'comment' => 512,
    'nick' => 50,
);

$rates = array(
    'name' => 50,
    'rate' => 1,
);

$tables = array(
    "images",
    "comments",
    "infos",
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