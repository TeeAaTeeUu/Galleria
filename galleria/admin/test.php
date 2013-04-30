<?php

function put_test_data($db) {
    $kuvia_lkm = $db->count_images_in_db();
    
    $comments = array(
        0 => "tämä on testi kommentti",
        1 => "joku hieno juttu tämäkin",
        2 => "toimii toimii",
        3 => "hehee :)",
        4 => "<b>a</b>",
        5 => "moikka moo",
        6 => "rupee kohta jo väsymään näihin juttuihin"
    );

    $nicks = array(
        0 => "TeeAaTeeUu",
        1 => "Testeri",
        2 => "Joku ukko",
        3 => "Hienomies99",
        4 => "anonymous",
        5 => "piilonimi",
        6 => "hermoheikko72"
    );

    for ($index = 0; $index < 40; $index++) {
        $kommentti = $comments[mt_rand(0, count($comments) -1)];
        $nick = $nicks[mt_rand(0, count($nicks) -1)];
        $image_id = mt_rand(1, $kuvia_lkm);

        echo 'Lisätty kommentti: ' . $kommentti . " by " . $nick . " kuvalle " . $image_id . '<br />' . "\n";
        $db->put_image_comment_to_db(array("kommentti" => $kommentti, "nick" => $nick, "image_id" => $image_id));
    };

    $tagit = array(
        "keltainen",
        "mustareunainen"
    );
    $mustareunainen = array(
        4, 1, 9, 6
    );
    $keltainen = array(
        10, 13, 5
    );

    foreach ($tagit as $tagi) {
        foreach ($$tagi as $kuva_id) {
            echo 'Lisätty tagi: ' . $tagi . " kuvalle " . $kuva_id . "<br />" . "\n";
            $db->put_tags_to_db(array("tags" => $tagi, "image_id" => $kuva_id));
        }
    }

    for ($index1 = 0; $index1 < 10; $index1++) {
        $kommentti = $comments[mt_rand(0, count($comments) -1)];
        $nick = $nicks[mt_rand(0, count($nicks) -1)];
        $tagi = $tagit[mt_rand(0, count($tagit) -1)];

        echo 'Lisätty kommentti: ' . $kommentti . " by " . $nick . " tagille " . $tagi . '<br />' . "\n";
        $db->put_tag_comment_to_db(array("kommentti" => $kommentti, "nick" => $nick, "tag_name" => $tagi));
    }

    for ($index2 = 0; $index2 < 200; $index2++) {
        $arvostelu = mt_rand(0, 5);
        $kuva_id = mt_rand(1, $kuvia_lkm);
        
        echo 'Lisätty arvostelu: ' . $arvostelu . " tähteä kuvalle " . $kuva_id . '<br />' . "\n";
        $db->put_rate_to_db(array("rate" => $arvostelu, "image_id" => $kuva_id));
    }
}
?>
