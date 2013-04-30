<?php

function __autoload($class_name) {
    include 'classes/' . $class_name . '.php';
}
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
    "http://www.w3.org/TR/html4/strict.dtd">
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title>3-column CSS layout, Step 6</title>
        <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.2/themes/smoothness/jquery-ui.css" />
        <link rel="stylesheet" href="css.css" />
        <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
        <script src="http://code.jquery.com/ui/1.10.2/jquery-ui.js"></script>
        <script>
            $(function() {
                $("#tabs").tabs();
            });
        </script>
        <style type="text/css" media="screen, print, projection">

            /* Easy clearing of floats (see http://positioniseverything.net/easyclearing.html) */
            .cf:after {
                display:block;
                clear:both;
                height:0;
                visibility:hidden;
                content:" ";
                font-size:0;
            }
            /* Does not validate – use conditional comments for this bit if you want valid CSS */
            .cf {*zoom:1;}
        </style>
    </head>
    <body>
        <div id="body">
            <div id="header" class="cf">
                <h1>Merkki-galleria</h1>
                <p>See <a href="http://www.456bereastreet.com/archive/201012/how_to_create_a_3-column_layout_with_css/">How to create a 3-column layout with CSS</a> for info on what this is.</p>
            </div>
            <div id="main" class="cf">
                <div id="content-1">
                    <?php
                    ini_set('display_errors', 1);
                    error_reporting(E_ALL | E_STRICT);
                    ini_set('error_log', 'script_errors.log');
                    ini_set('log_errors', 'On');

                    $db = new database();

                    $images = $db->get_images_names_and_ids_from_db(12);


                    for ($index = 0; $index < count($images) / 2; $index++) {
                        echo '<div class="kuva"><a ' . "\n" . 'href="?image_id=' . $images[$index]["id"] . '"><img src="small_images/' . $images[$index]["name"] . '" /></a></div>';
                    }
                    ?>
                </div>
                <div id="content-2">
                    <div id="content-2-1">
                        <?php
                        include_once 'aliosiot/kuvandata.php';
                        ?>

                    </div>
                    <div id="content-2-2">
                        <?php
                        for ($index = count($images) / 2; $index < count($images); $index++) {
                            echo '<div class="kuva"><a ' . "\n" . 'href="?image_id=' . $images[$index]["id"] . '"><img src="small_images/' . $images[$index]["name"] . '" /></a></div>';
                        }
                        ?>
                    </div>
                </div>
            </div>
            <div id="footer" class="cf">
                <?php
                include 'aliosiot/footer.php';
                ?>
            </div>
        </div>
    </body>
</html>