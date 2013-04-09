<?php

class database {

    private $mysql;

    public function __construct() {
        $this->mysql = new mysql();
    }

    public function put_images_to_db($images_array) {
//        var_dump($images_array);

        foreach ($images_array as $file) {
            $this->mysql->put_query_from_array("images", array("name" => $file));
        }
    }

    public function put_comment_to_db($comment_array) {
        $temp_array = array(
            "comment" => $comment_array["kommentti"],
            "nick" => $comment_array["nick"],
            "name" => $comment_array["name"],
        );
        $this->mysql->put_query_from_array("comments", $temp_array);
    }

    public function put_rate_to_db($rate_array) {
        $temp_array = array(
            "rate" => $rate_array["rate"],
            "name" => $rate_array["name"],
        );
        $this->mysql->put_query_from_array("rates", $temp_array);
    }

    public function put_info_to_db($info_array) {
        $temp_array = array(
            "nimi" => $info_array["nimi"],
            "kenen" => $info_array["kenen"],
            "nick" => $info_array["nick"],
            "name" => $info_array["name"],
        );
        $this->mysql->put_query_from_array("infos", $temp_array);
    }

    public function get_images_names_from_db() {
        $db_content = $this->mysql->get_query_select("name", "images");
        $temp = array();

        foreach ($db_content as $file) {
            $temp[] = $file["name"];
        }
        return $temp;
    }

    public function get_comments_from_db($name) {
        return $this->mysql->get_query_select("comment, nick, name", "comments", "name", $name);
    }
    
    public function get_info_from_db($name) {
        $temp = $this->mysql->get_query_select("nimi, nick, name, kenen", "infos", "name", $name);
        if(empty($temp) == false)
                return $temp[0];
        return array("nimi" => "NA", "kenen" => "NA", "nick" => "NA", "name" => $name);
    }

    public function get_rates_sum_from_db($name) {
        $sum = 0;
        $temp = $this->mysql->get_query_select("rate", "rates", "name", $name);
        foreach ($temp as $value) {
            $sum += $value["rate"];
        }
        $maara = count($temp);
        if ($maara > 0)
            return "" . $sum / $maara . " yhteensä $maara arvostelijalta.";
        return "ei vielä arvosteltu";
    }

}

?>
