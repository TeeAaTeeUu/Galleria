<?php
$tagit = $db->get_all_tags_from_db();

echo '<h3>tagit</h3>';

echo '<ul>' . "\n";
foreach ($tagit as $tag) {
    echo '<li class="tags"><a href="?tag=' . $tag . '">&bull; ' . $tag . ' </a></li>' . "\n";
}
echo '</ul>' . "\n";
?>
