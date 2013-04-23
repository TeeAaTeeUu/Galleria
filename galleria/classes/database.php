<?php

class database {

    private $mysql;

    public function __construct() {
        $this->mysql = new mysql();
    }
    
    public function get_mysql() {
        return $this->mysql;    
    }

    public function put_images_to_db($images_array) {
        foreach ($images_array as $file) {
            $this->mysql->put_query_from_array("images", array("name" => $file));
        }
    }
    
    public function exists_user($username) {
        return $this->mysql->exists_in_db("users", "nick", $username);
    }
    
    public function get_user_hash($username) {
        $temp = $this->mysql->get_query_select("pswd_hash", "users", "nick", $username);
        return $temp[0]["pswd_hash"];
    }

    public function put_comment_to_db($comment_array) {
        $temp_array = array(
            "comment" => $comment_array["kommentti"],
            "nick" => $comment_array["nick"],
            "image_id" => $comment_array["image_id"],
        );
        $this->mysql->put_query_from_array("comments", $temp_array);
    }

    public function put_tags_to_db($tags_array) {
        $tags = $tags_array["tags"];
        $image_id = $tags_array["image_id"];

        $user_tags = explode(" ", $tags);

        $old_tags = $this->get_tags_from_db($image_id);

        $new_tags = array_diff($user_tags, $old_tags);

        foreach ($new_tags as $tag) {
            $this->mysql->put_query_from_array("tags", array("tag" => $tag, "image_id" => $image_id));
        }
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

    public function get_images_names_and_ids_from_db($how_much = null) {
        return $this->mysql->get_query_select("name, id", "images", null, null, "RAND()", false, null, $how_much);
    }

    public function get_images_names_and_ids_from_db_from_array($image_ids) {
        return $this->mysql->get_query_select("name, id", "images", "id", $image_ids, null, true);
    }

    public function get_images_names_from_db() {
        $temp = $this->mysql->get_query_select("name", "images");
        $temp2 = array();

        foreach ($temp as $image) {
            $temp2[] = $image["name"];
        }
        return $temp2;
    }

    public function get_images_from_db_by_tag($tag) {
        $exists = $this->mysql->exists_in_db("tags", "tag", $tag);
        if ($exists == true) {
            $image_ids = $this->mysql->get_query_select("image_id", "tags", "tag", $tag);
            $temp = array();
            foreach ($image_ids as $image_id) {
                $temp[] = $image_id["image_id"];
            }
            $images = $this->get_images_names_and_ids_from_db_from_array($temp);
            return $images;
        }
        else
            return null;
    }

    public function get_image_name_from_db($image_id) {
        $temp = $this->mysql->get_query_select("name", "images", "id", $image_id);
        if (isset($temp[0]["name"]))
            return $temp[0]["name"];
        else
            return "apy.jpg";
    }

    public function get_image_id_from_db($name) {
        $temp = $this->mysql->get_query_select("id", "images", "name", $name);
        return $temp[0]["id"];
    }

    public function get_comments_from_db($image_id) {
        return $this->mysql->get_query_select("comment, nick", "comments", "image_id", $image_id);
    }

    public function get_tags_from_db($image_id) {
        $temp = $this->mysql->get_query_select("tag", "tags", "image_id", $image_id);
        $temp2 = array();

        foreach ($temp as $image) {
            $temp2[] = $image["tag"];
        }
        return $temp2;
    }

    public function get_info_from_db($image_id) {
        $temp = $this->mysql->get_query_select("nimi, nick, kenen", "infos", "image_id", $image_id, "aika DESC");
        if (empty($temp) == false) {
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
