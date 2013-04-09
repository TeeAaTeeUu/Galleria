<?php

$info = $db->get_info_from_db($pic);
$rate = $db->get_rates_sum_from_db($pic);

?>

<table>
    <tr>
        <td>Merkin nimi</td>
        <td><?php echo $info["nimi"] ?></td>
    </tr>
    <tr>
        <td>Kenen merkki</td>
        <td><?php echo $info["kenen"] ?></td>
    </tr>
    <tr>
        <td>tähdet</td>
        <td><?php echo $rate ?></td>
    </tr>
</table>
<p>
<form method="post">
    <label for="rate">Kuinka hyvä merkki on?</label><br />
    <select name="rate"> 
        <option value="0" >roskaa</option>
        <option value="1" >1 tähti</option>
        <option value="2" >2 tähtiä</option>
        <option value="3" selected="selected">3 tähteä</option>
        <option value="4" >4 tähteä</option>
        <option value="5" >5 tähteä</option>
    </select>
    <br />
    <input type="hidden" name="name" value="<?php echo $pic ?>" />
    <input type="submit" name="pisteita" value="lähetä" />
</form>
</p>