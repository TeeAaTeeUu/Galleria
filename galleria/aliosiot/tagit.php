<?php
$tags = $db->get_tags_from_db($pic);
?>

<form method="post">
    <label for="nimi">Anna tagit erottaen ne välilyönnein:</label><br />
    <input name="tags" type="text" />

    <div>
        <p><?php
            $eka_kerta = true;
            foreach ($tags as $tag) {
                if ($eka_kerta) {
                    $eka_kerta = false;
                }
                else
                    echo " , ";
                echo '<a href="?tag=' . $tag . '">' . $tag . '</a>';
            }
            ?></p>
    </div>

    <input type="hidden" name="image_id" value="<?php echo $pic ?>" />
    <input type="submit" name="tageja" value="lähetä" />

</form>