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
    <body><?php
        if (isset($_POST["admin"])) {
            $password = $_POST["password"];
            $username = $_POST["user"];

            include '../classes/database.php';
            $db = new database();

            if ($db->exists_user($username)) {
                $password_hash = $db->get_user_hash($username);

                if (crypt($password, $password_hash) == $password_hash) {

                    if (isset($_POST["tables"])) {
                        if ($_POST["tables"] == 1) {

                            include 'install.php';
                            create_tables($db);
                        }
                    }
                    if (isset($_POST["images"])) {
                        if ($_POST["images"] == 1) {

                            include 'files.php';
                            $files = new files($db);

                            $files->put_new_images_to_db();
                        }
                    }
                    if (isset($_POST["datas"])) {
                        if ($_POST["datas"] == 1) {
                            
                            SplitSQL($file, $db, $delimiter = ';');
                        }
                    }
                }
            }
        }
        ?>
        <form method="post">
            <input type="checkbox" name="tables" value="1">Haluat alustaa taulukot<br>
            <input type="checkbox" name="images" value="1">Haluat asettaa kuvat
            <hr />
            <label for="user">Käyttäjänimi</label><br />
            <input name="user" type="text" /><br />
            <label for="password">Salasana</label><br />
            <input name="password" type="password" /><br />
            <input type="submit" name="admin" value="lähetä" />
        </form>
    </body>
</html>

<?php

// http://stackoverflow.com/questions/1883079/best-practice-import-mysql-file-in-php-split-queries/2011454#2011454
//  answered Jan 6 '10 at 7:19 Alix Axel

function SplitSQL($file, $db, $delimiter = ';') {
    set_time_limit(0);
    
    $mysql = $db->get_mysql();

    if (is_file($file) === true) {
        $file = fopen($file, 'r');

        if (is_resource($file) === true) {
            $query = array();

            while (feof($file) === false) {
                $query[] = fgets($file);

                if (preg_match('~' . preg_quote($delimiter, '~') . '\s*$~iS', end($query)) === 1) {
                    $query = trim(implode('', $query));

                    if ($mysql->put_query_bulk($query) === false) {
                        echo '<h3>ERROR: ' . $query . '</h3>' . "\n";
                    } else {
                        echo '<h3>SUCCESS: ' . $query . '</h3>' . "\n";
                    }

                    while (ob_get_level() > 0) {
                        ob_end_flush();
                    }

                    flush();
                }

                if (is_string($query) === true) {
                    $query = array();
                }
            }

            return fclose($file);
        }
    }

    return false;
}
?>