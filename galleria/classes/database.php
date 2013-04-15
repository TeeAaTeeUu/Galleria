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
            "image_id" => $comment_array["image_id"],
        );
        $this->mysql->put_query_from_array("comments", $temp_array);
    }

    public function put_rate_to_db($rate_array) {
        $temp_array = array(
            "rate" => $rate_array["rate"],
            "image_id" => $rate_array["image_id"],
        );
        $this->mysql->put_query_from_array("rates", $temp_array);
    }

    public function put_info_to_db($info_array) {
        $temp_array = array(
            "nimi" => $info_array["nimi"],
            "kenen" => $info_array["kenen"],
            "nick" => $info_array["nick"],
            "image_id" => $info_array["image_id"],
        );
        $this->mysql->put_query_from_array("infos", $temp_array);
    }

    public function get_images_names_from_db($how_much = null) {
        return $this->mysql->get_query_select("name, id", "images", null, null, "RAND()", false, null, $how_much);
    }
    
    public function  get_image_name_from_db($image_id) {
        $temp = $this->mysql->get_query_select("name", "images", "id", $image_id);
        if(isset($temp[0]["name"]))
            return $temp[0]["name"];
        else return "apy.jpg";
    }
    
   public function  get_image_id_from_db($name) {
        $temp = $this->mysql->get_query_select("id", "images", "name", $name);
        return $temp[0]["id"];
    }

    public function get_comments_from_db($image_id) {
        return $this->mysql->get_query_select("comment, nick", "comments", "image_id", $image_id);
    }
    
    public function get_info_from_db($image_id) {
        $temp = $this->mysql->get_query_select("nimi, nick, kenen", "infos", "image_id", $image_id, "aika DESC");
        if(empty($temp) == false) {
            return $temp[0];
        }
        return array("nimi" => "NA", "kenen" => "NA", "nick" => "NA");
    }

    public function get_rates_sum_from_db($image_id) {
        $sum = 0;
        $temp = $this->mysql->get_query_select("rate", "rates", "image_id", $image_id);
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
