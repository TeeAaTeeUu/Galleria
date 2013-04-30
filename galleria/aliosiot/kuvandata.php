<?php
$post = array(
    "nimi",
    "name",
    "image_id",
    "rate",
    "kenen",
    "kommentti",
    "tietoa",
    "kommentointia",
    "pisteita",
    "nick",
    "tags",
    "tag_name",
    "tageja",
    "tag_kommentti"
);

if (empty($_POST) == false) {
    foreach ($post as $value) {
        if (isset($_POST[$value]) == true)
            $post[$value] = $_POST[$value];
        else
            $post[$value] = null;
    }

    if (empty($post["kommentointia"]) == false) {
        if (empty($post["tag_kommentti"]) == true) {
                $db->put_image_comment_to_db($post);
        } else {
            $db->put_tag_comment_to_db($post);
        }
    }
};

if (empty($post["pisteita"]) == false) {
    $db->put_rate_to_db($post);
};

if (empty($post["tietoa"]) == false) {
    $db->put_info_to_db($post);
};

if (empty($post["tageja"]) == false) {
    $db->put_tags_to_db($post);
};

if (isset($_GET["tag"]) == false) {
    if (isset($_GET["image_id"])) {
        $kuva = $db->get_image_name_from_db($_GET["image_id"]);
    } else {
        $kuva = "apy.jpg";
    }
    $pic = $db->get_image_id_from_db($kuva);
    echo '<img src="big_images/' . $kuva . '" />' . "\n";

    include 'tabs.php';
} else {
    $tag_images = $db->get_images_from_db_by_tag($_GET["tag"]);

    if (empty($tag_images)) {
        echo "<p>Nyt taisi tapahtua virhe.</p>";
    } else {

        echo '<div style="text-align:center">';

        echo "<h2>" . $_GET["tag"] . "</h2>";

        for ($index = 0; $index < count($tag_images); $index++) {
            echo '<span class="kuva" style=""><a ' . "\n" . 'href="?image_id=' . $tag_images[$index]["id"] . '"><img src="small_images/' . $tag_images[$index]["name"] . '" /></a></span>';
        }

        echo "</div>";
        ?>        
        <div id="tabs">
            <ul>
                <li><a href="#kommentit">Kommentointi</a></li>
            </ul>
            <div id="kommentit">
                <?php
                include 'kommentit.php';
                ?>
            </div>
        </div>
        <?php
    }
}
?>