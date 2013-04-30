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
    public function user_is_admin($username) {
        return $this->mysql->exists_in_db("users", array("nick", "onko_admin"), array($username, 1));
    }
    
    public function get_user_hash($username) {
        $temp = $this->mysql->get_query_select("pswd_hash", "users", "nick", $username);
        return $temp[0]["pswd_hash"];
    }

    public function put_image_comment_to_db($comment_array) {
        $temp_array = array(
            "comment" => $comment_array["kommentti"],
            "nick" => $comment_array["nick"],
            "image_id" => $comment_array["image_id"],
        );
        $this->mysql->put_query_from_array("comments", $temp_array);
    }
    
    public function put_tag_comment_to_db($comment_array) {
        $temp_array = array(
            "comment" => $comment_array["kommentti"],
            "nick" => $comment_array["nick"],
            "tag_id" => $this->get_tag_id($comment_array["tag_name"]),
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
            $this->mysql->put_query_from_array("tags", array("tag_name" => $tag, "image_id" => $image_id));
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
    
    public function put_user_to_db($nick, $password_hash, $admin = 0) {
        $temp_array = array(
            "nick" => $nick,
            "onko_admin" => $admin,
            "pswd_hash" => $password_hash,
        );
        $this->mysql->put_query_from_array("users", $temp_array);
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
        $exists = $this->mysql->exists_in_db("tags", "tag_name", $tag);
        if ($exists == true) {
            $image_ids = $this->mysql->get_query_select("image_id", "tags", "tag_name", $tag);
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

    public function get_image_comments_from_db($image_id) {
        return $this->mysql->get_query_select("comment, nick", "comments", "image_id", $image_id);
    }
    
    public function get_all_comments_from_db() {
        return $this->mysql->get_query_select("*", "comments", null, null, "id DESC");
    }
    public function get_all_infos_from_db() {
        return $this->mysql->get_query_select("*", "infos", null, null, "id DESC");
    }
    
    public function count_images_in_db() {
        $temp = $this->mysql->get_query_select("COUNT(*)", "images");
        return $temp[0]["COUNT(*)"];
    }
    
    public function get_tag_comments_from_db($tag_name) {
        $tag_id = $this->get_tag_id($tag_name);
        return $this->mysql->get_query_select("comment, nick", "comments", "tag_id", $tag_id);
    }

    public function get_tags_from_db($image_id) {
        $temp = $this->mysql->get_query_select("tag_name", "tags", "image_id", $image_id);
        $temp2 = array();

        foreach ($temp as $image) {
            $temp2[] = $image["tag_name"];
        }
        return $temp2;
    }
    
    public function get_tag_id($tag_name) {
        $temp = $this->mysql->get_query_select("id", "tags", "tag_name", $tag_name,null,true,null,1);
        if(empty($temp))
            return false;
        return $temp[0]["id"];
    }
    
    public function get_all_tags_from_db() {
        $temp = $this->mysql->get_query_select("DISTINCT(tag_name)", "tags");
        $temp2 = array();

        foreach ($temp as $image) {
            $temp2[] = $image["tag_name"];
        }
        return $temp2;
    }
    
    public function count_images_from_db() {
        $temp = $this->mysql->get_query_select("COUNT(id)", "images");
        return $temp[0];

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
            return "" . round($sum / $maara, 1) . " yhteensä $maara arvostelijalta.";
        return "ei vielä arvosteltu";
    }
    
    public function table_exists_in_db($table) {
        return $this->mysql->table_exists_in_db($table);
    }
    
    public function delete_comment_by_id($comment_id) {
        return $this->mysql->delete_query_from_array("comments", "id", $comment_id);
    }
    
    public function delete_info_by_id($info_id) {
        return $this->mysql->delete_query_from_array("infos", "id", $info_id);
    }
    

}

?>
