<?php
        if (empty($pic) == false) {
            $comments = $db->get_comments_from_db($pic);

            foreach ($comments as $comment) {
                echo '<div>
                    <p>' . $comment["comment"] . '</p>
                        <p>' . $comment["nick"] . '</p>
                </div>
                <hr />';
            }
        }
        ?>
        <form method="post">
            <table>
                <tr>
                    <td>
                        <label for="kommentti">Kommenttisi merkistä</label><br />
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
                        <input type="hidden" name="name" value="<?php echo $pic ?>" />
                        <input type="submit" name="kommentointia" value="lähetä" />
                    </td>
                    <td>

                    </td>
                </tr>
            </table>
        </form>