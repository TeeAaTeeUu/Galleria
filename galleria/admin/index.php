<?php
ini_set('display_errors', 1);
error_reporting(E_ALL | E_STRICT);
ini_set('error_log', 'script_errors.log');
ini_set('log_errors', 'On');

function __autoload($class_name) {
    include "../classes/" . $class_name . '.php';
}

// Original PHP code by Chirp Internet: www.chirp.com.au
// Please acknowledge use of this code by including this header.

function better_crypt($input, $rounds = 7) {
    $salt = "";
    $salt_chars = array_merge(range('A', 'Z'), range('a', 'z'), range(0, 9));
    for ($i = 0; $i < 22; $i++) {
        $salt .= $salt_chars[array_rand($salt_chars)];
    } return crypt($input, sprintf('$2a$%02d$', $rounds) . $salt);
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
    "http://www.w3.org/TR/html4/strict.dtd">
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title>3-column CSS layout, Step 6</title>
        </meta>
    <body>
    <a href="../">pääsivulle</a>
    <hr /><?php
    if (isset($_POST["admin"])) {
        $password = $_POST["password"];
        $username = $_POST["user"];

        include '../classes/database.php';
        $db = new database();

        if ($db->table_exists_in_db("users")) {
            if ($db->exists_user($username)) {
                kayttaja_loytyy($password, $username, $db);
            }
        } else {
            if (isset($_POST["valinta"]) == false) {
                echo "<table><tr><td><p>Luodaanko antamasi mukaiset tunnukset?</p>" . "\n";
                echo "<p><i>Huom! (samalla luodaan kaikki taulut)</i></p></td>" . "\n";

                echo '<td><form method="post"><input type="hidden" name="user" value="' . $_POST["user"] . '" />';
                echo '<input type="hidden" name="password" value="' . $_POST["password"] . '" />';
                echo '<input type="hidden" name="admin" value="valinta" />';
                echo '<input type="submit" name="valinta" value="kyllä" />';
                echo '<input type="submit" name="valinta" value="ei" /></form></td></tr></table>';

                echo "<hr />" . "\n";
            } elseif ($_POST["valinta"] == "kyllä") {
                include_once 'install.php';
                create_tables($db, "create");

                $password_hash = better_crypt($_POST["password"]);

                $db->put_user_to_db($username, $password_hash, 1);

                echo "<p>Onnistui!</p>" . "\n";
            }
        }
    }
    ?>
    <form method="post">
        <input type="checkbox" name="drop" value="1">Haluat poistaa taulukot<br />
        <input type="checkbox" name="tables" value="1">Haluat luoda taulukot<br />
        <input type="checkbox" name="images" value="1">Haluat asettaa kuvat<br />
        <input type="checkbox" name="data" value="1">Haluat asettaa testidataa<br />
        <input type="checkbox" name="comment" value="1">Haluat poistaa kommentteja<br />
        <input type="checkbox" name="tieto" value="1">Haluat poistaa tietoja<br />
        <hr />
        <label for="user">Käyttäjänimi</label><br />
        <input name="user" type="text" value="<?php if (isset($_POST["user"])) echo $_POST["user"] ?>" /><br />
        <label for="password">Salasana</label><br />
        <input name="password" type="password" value="<?php if (isset($_POST["password"])) echo $_POST["password"] ?>" /><br />
        <input type="submit" name="admin" value="lähetä" />
    </form>
</body>
</html>

<?php

function kayttaja_loytyy($password, $username, $db) {
    $password_hash = $db->get_user_hash($username);

    if (crypt($password, $password_hash) == $password_hash) {
        if ($db->user_is_admin($username) == true) {

            if (isset($_POST["drop"])) {
                if ($_POST["drop"] == 1) {

                    include_once 'install.php';
                    create_tables($db, "drop");
                }
            }
            if (isset($_POST["tables"])) {
                if ($_POST["tables"] == 1) {

                    include_once 'install.php';
                    create_tables($db, "create");
                }
            }
            if (isset($_POST["images"])) {
                if ($_POST["images"] == 1) {

                    include 'files.php';
                    $files = new files($db);

                    $files->put_new_images_to_db();
                }
            }
            if (isset($_POST["data"])) {
                if ($_POST["data"] == 1) {
                    include_once "test.php";
                    put_test_data($db);
                }
            }
            if (isset($_POST["comment"])) {
                if ($_POST["comment"] == 1) {
                    include_once 'comments.php';
                    listaa_kommentit($db);
                }
            }
            if (isset($_POST["kommentti_poisto"])) {
                if ($_POST["kommentti_poisto"] == "poista") {
                    include_once 'comments.php';
                    poista_kommentit($db);
                }
            }
            if (isset($_POST["tieto"])) {
                if ($_POST["tieto"] == 1) {
                    include_once 'infos.php';
                    listaa_tiedot($db);
                }
            }
            if (isset($_POST["tieto_poisto"])) {
                if ($_POST["tieto_poisto"] == "poista") {
                    include_once 'infos.php';
                    poista_tiedot($db);
                }
            }
            echo "<hr />";
        }
    }
}
?>