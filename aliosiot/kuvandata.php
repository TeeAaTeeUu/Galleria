<?php
$post = array(
    "nimi",
    "name",
    "rate",
    "kenen",
    "kommentti",
    "tietoa",
    "kommentointia",
    "pisteita",
    "nick",
);

if (empty($_POST) == false) {
    foreach ($post as $value) {
        if (isset($_POST[$value]) == true)
            $post[$value] = $_POST[$value];
    }

    if (empty($post["kommentointia"]) == false) {
        $db->put_comment_to_db($post);
    };

    if (empty($post["pisteita"]) == false) {
        $db->put_rate_to_db($post);
    };
    
    if (empty($post["tietoa"]) == false) {        
        $db->put_info_to_db($post);
    };
}
?>

<div id="tabs">
    <ul>
        <li><a href="#tiedot">Tiedot</a></li>
        <li><a href="#muokkaa">Muokkaa tietoja</a></li>
        <li><a href="#kommentit">Kommentointi</a></li>
    </ul>
    <div id="tiedot">
        <?php
        include 'tiedot.php';
        ?>
    </div>
    <div id="muokkaa">
        <?php
        include 'muokkaa.php';
        ?>
    </div>
    <div id="kommentit">
        <?php
        include 'kommentit.php';
        ?>
    </div>
</div>