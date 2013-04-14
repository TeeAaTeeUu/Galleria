<?php

ini_set('display_errors', 1);
error_reporting(E_ALL | E_STRICT);
ini_set('error_log', 'script_errors.log');
ini_set('log_errors', 'On');

function __autoload($class_name) {
    include "../classes/" . $class_name . '.php';
}

include_once '../classes/database.php';

$files = new files();
$files->put_new_images_to_db();

class files {

    private $db;

    public function __construct() {
        $this->db = new database();
    }

    public function directoryToArray() {
        $directory = scandir(dirname(getcwd()) .  "/small_images/");
        var_dump(dirname(getcwd()) . "/small_images/");
        $temp_directory = array();

        foreach ($directory as $file) {
            if (!(strcmp($file, ".") == 0 OR strcmp($file, "..") == 0))
                $temp_directory[] = $file;
        }
        var_dump($temp_directory);
        return $temp_directory;
    }

    public function put_new_images_to_db() {
        $old_images = $this->db->get_images_names_from_db();
        var_dump($old_images);

        $all_images = $this->directoryToArray();

        var_dump($all_images);

        $new_images = array_diff($all_images, $old_images);


        var_dump($new_images);

        if (empty($new_images) == false)
            $this->db->put_images_to_db($new_images);
    }

    public function put_new_rate_image_to_db($name, $rate) {
        return $this->db->put_new_rate_image_to_db($name, $rate);
    }

    public function get_images_from_db() {
        $images = $this->db->get_images_names_from_db();

//        foreach ($images as $file) {
//            echo $file . "<br />" . "\n";
//        }
        return($images);
    }

}

?>
