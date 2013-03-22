<?php

include_once 'mysql.php';

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

    public function get_images_names_from_db() {
        $db_content = $this->mysql->get_query_select("name", "images");
        $temp = array();

        foreach ($db_content as $file) {
            $temp[] = $file["name"];
        }
        return $temp;
    }

    public function put_new_rate_image_to_db($name, $rate) {
        if (exists_in_db("names", "name", $rate)) {
            $this->mysql->put_query_from_array("rates", array("name" => $name, "rate" => $rate));
            return true;
        }
        return false;
    }
}

?>
