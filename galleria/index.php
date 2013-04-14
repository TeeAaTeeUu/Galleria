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
        <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
        <script src="http://code.jquery.com/ui/1.10.2/jquery-ui.js"></script>
        <script>
            $(function() {
                $("#tabs").tabs();
            });
        </script>
        <style type="text/css" media="screen, print, projection">
            html,
            body {
                margin:0;
                padding:0;
                color:#000;
                background:#fff;
            }
            /* http://www.456bereastreet.com/archive/201012/how_to_create_a_3-column_layout_with_css/ */
            #body {
                width:1000px;
                margin:0 auto;
                background:#ddd;
            }
            #header {
                padding:10px;
                background:#fdd;
                text-align: center;
            }
            #content-1 {
                float:left;
                width:200px;
                background:#bfb;
            }
            #content-2 {
                float:right;
                width:800px;
            }
            #content-2-1 {
                float:left;
                width:600px;
                background:#ddf;
            }
            #content-2-2 {
                float:right;
                width:200px;
                background:#dff;
            }
            img {
                border: 0;
                padding: 0px;
                margin: 0px;
            }

            #footer {
                padding:10px;
                background:#ff9;
            }
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
                <h1>3-column CSS layout, Step 6</h1>
                <p>See <a href="/archive/201012/how_to_create_a_3-column_layout_with_css/">How to create a 3-column layout with CSS</a> for info on what this is.</p>
                <p>This is <code>&lt;div id="header"&gt;</code>.</p>
            </div>
            <div id="main" class="cf">
                <div id="content-1">
                    <?php
                    ini_set('display_errors', 1);
                    error_reporting(E_ALL | E_STRICT);
                    ini_set('error_log', 'script_errors.log');
                    ini_set('log_errors', 'On');

                    $db = new database();

                    $images = $db->get_images_names_from_db(12);
                    

                    for ($index = 0; $index < count($images) / 2; $index++) {
                        echo '<div class="kuva"><a ' . "\n" . 'href="?image_id=' . $images[$index]["id"] . '"><img src="small_images/' . $images[$index]["name"] . '" /></a></div>';
                    }
                    ?>
                </div>
                <div id="content-2">
                    <div id="content-2-1">
                        <?php
                        if (isset($_GET["image_id"])) {
                            $kuva = $db->get_image_name_from_db($_GET["image_id"]);
                        } else {
                            $kuva = "apy.jpg";
                        }
                        $pic = $db->get_image_id_from_db($kuva);

                        echo '<img src="big_images/' . $kuva . '" />';

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
                <p>This is <code>&lt;div id="footer"&gt;</code>.</p>
            </div>
        </div>
    </body>
</html>