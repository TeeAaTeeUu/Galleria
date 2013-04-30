<?php

function listaa_tiedot($db) {
    $infos = $db->get_all_infos_from_db();

    echo '<h2>tiedot</h2>';
    echo '<form method="post">' . "\n";
    echo '<table border="1">' . "\n";
    echo '<tr><td><b>poistetaanko</b></td><td><b>id</b></td><td><b>kuvan id</b></td><td><b>merkin nimi</b></td><td><b>kommentoija</b></td><td><b>kenen merkki</b></td><td><b>koska luotu</b></td></tr>' . "\n";
    foreach ($infos as $info) {
        echo '<tr><td><input type="checkbox" name="' . $info["id"] . '" value="1" /></td><td>' . $info["id"] . '</td><td>' . $info["image_id"] . '</td><td>' . $info["nimi"] . '</td><td>' . $info["nick"] . '</td><td>' . $info["kenen"] . '</td><td>' . $info["aika"] . '</td></tr>' . "\n";
    }
    echo '</table>' . "\n";
    
    echo '<input name="user" type="hidden" value="' . $_POST["user"] . '" />';
    echo '<input name="password" type="hidden" value="' . $_POST["password"] . '" />';
    echo '<input type="hidden" name="admin" value="valinta" />';
    echo '<input type="submit" name="tieto_poisto" value="poista" />' . "\n";
    echo '</form>' . "\n";
}

function poista_tiedot($db) {
    $infos = $db->get_all_infos_from_db();
    
    foreach ($infos as $info) {
        if(isset($_POST[$info["id"]])) {
            if($_POST[$info["id"]] == 1) {
                $db->delete_info_by_id($info["id"]);
            }
        }
    }
}

?>