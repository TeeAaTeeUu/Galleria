<?php
if (empty($pic) == false) {
    $comments = $db->get_image_comments_from_db($pic);

    print_comments($comments);
}

if (isset($_GET["tag"])) {
    $comments = $db->get_tag_comments_from_db($_GET["tag"]);
    
    print_comments($comments);
}
?>
<form method="post">
    <table>
        <tr>
            <td><?php
                if (isset($_GET["tag"]) == false) {
                    ?>
                    <label for="kommentti">Kommenttisi merkistä</label><br />
                    <?php
                } else {
                    ?>

                    <label for="kommentti">Kommenttisi tagista</label><br />

                    <?php
                };
                ?>
                <textarea name="kommentti"></textarea>
            </td>
            <td>
            </td>
        </tr>
        <tr>
            <td>
                <label for="nick">Nimimerkkisi</label><br />
                <input name="nick" type="text" />
            </td>
            <td>
            </td>
        </tr>
        <tr>
            <td>
                <?php
                if (isset($_GET["tag"]) == false) {
                    ?>
                    <input type="hidden" name="image_id" value="<?php echo $pic ?>" />
                    <?php
                } else {
                    ?>

                    <input type="hidden" name="tag_kommentti" value="1" />
                    <input type="hidden" name="tag_name" value="<?php echo $_GET["tag"] ?>" />

                    <?php
                };
                ?>
                <input type="submit" name="kommentointia" value="lähetä" />
            </td>
            <td>

            </td>
        </tr>
    </table>
</form>
<?php

function print_comments($comments) {
    foreach ($comments as $comment) {
        echo '<div>
                    <p>' . $comment["comment"] . '</p>
                        <p>- ' . $comment["nick"] . ' -</p>
              </div>
              <hr />';
    }
}
?>