<?php

function listaa_kommentit($db) {
    $comments = $db->get_all_comments_from_db();

        echo '<h2>kommentit</h2>';
    echo '<form method="post">' . "\n";
    echo '<table border="1">' . "\n";
    echo '<tr><td><b>poistetaanko</b></td><td><b>id</b></td><td><b>kuvan id</b></td><td><b>kategorian id</b></td><td><b>kommentti</b></td><td><b>kommentoija</b></td><td><b>koska luotu</b></td></tr>' . "\n";
    foreach ($comments as $comment) {
        echo '<tr><td><input type="checkbox" name="' . $comment["id"] . '" value="1" /></td><td>' . $comment["id"] . '</td><td>' . $comment["image_id"] . '</td><td>' . $comment["tag_id"] . '</td><td>' . $comment["comment"] . '</td><td>' . $comment["nick"] . '</td><td>' . $comment["aika"] . '</td></tr>' . "\n";
    }
    echo '</table>' . "\n";
    
    echo '<input name="user" type="hidden" value="' . $_POST["user"] . '" />';
    echo '<input name="password" type="hidden" value="' . $_POST["password"] . '" />';
    echo '<input type="hidden" name="admin" value="valinta" />';
    echo '<input type="submit" name="kommentti_poisto" value="poista" />' . "\n";
    echo '</form>' . "\n";
}

function poista_kommentit($db) {
    $comments = $db->get_all_comments_from_db();
    
    foreach ($comments as $comment) {
        if(isset($_POST[$comment["id"]])) {
            if($_POST[$comment["id"]] == 1) {
                $db->delete_comment_by_id($comment["id"]);
            }
        }
    }
}

?>