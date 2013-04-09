<form method="post">
    <table>
        <tr>
            <td>
                <label for="nimi">Mikä merkki tämä on?</label><br />
                <input name="nimi" type="text" />
            </td>
            <td>

            </td>
        </tr>
        <tr>
            <td>
                <label for="kenen">Kenen merkki tämä on?</label><br />
                <input name="kenen" type="text" />
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
                <input type="submit" name="tietoa" value="lähetä" />
            </td>
            <td>

            </td>
        </tr>
    </table>
</form>