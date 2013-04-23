<?php

function create_tables($db) {

    $images = array(
        'name' => 50,
    );

    $infos = array(
        'image_id' => 1,
        'nimi' => 75,
        'nick' => 50,
        'kenen' => 50,
    );

    $comments = array(
        'image_id' => 1,
        'comment' => 512,
        'nick' => 50,
    );

    $rates = array(
        'image_id' => 1,
        'rate' => 1,
    );

    $users = array(
        'nick' => 50,
        'onko_admin' => 1,
        'pswd_hash' => 60,
    );

    $tags = array(
        'tag' => 50,
        'image_id' => 1,
    );

    $tables = array(
        "images",
        "comments",
        "infos",
        "rates",
        "tags",
        "users",
    );

    $db = $db->get_mysql();

//$dbname = $db->dbname;

    $query;

    echo '<pre>';
    
    echo '<h2>luontikäskyt</h2>';
    foreach ($tables as $value) {
        $table = $db->etuliite . $value;
        $query = "";


        $query = "CREATE TABLE IF NOT EXISTS " . "\n" . $table . "( id INT NOT NULL AUTO_INCREMENT, PRIMARY KEY (id)" . "\n";

        foreach (${$value} as $key => $value) {
            $query .= ", ";
            if (strpos($key, '_id') !== false) {
                $query .= "$key INT";
            }
            else
                $query .= "$key VARCHAR($value)" . "\n";
        }

        $query .= ", aika timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP" . "\n";
        $query .= " )";

        echo $query . "\n" . "\n";

        mysql_query($query) or die(mysql_error());
    }
    echo '</pre>';
}

?>