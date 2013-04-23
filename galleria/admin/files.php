<?php

class files {

    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    private function directoryToArray() {
        $directory = scandir(dirname(getcwd()) . "/small_images/");
        $temp_directory = array();

        foreach ($directory as $file) {
            if (!(strcmp($file, ".") == 0 OR strcmp($file, "..") == 0))
                $temp_directory[] = $file;
        }
        return $temp_directory;
    }

    public function put_new_images_to_db() {
        echo '<pre>';
        $old_images = $this->db->get_images_names_from_db();
        
        echo '<h2>vanhat</h2>';
        
        var_dump($old_images);

        $all_images = $this->directoryToArray();
        
        echo '<h2>juuressa</h2>';

        var_dump($all_images);

        $new_images = array_diff($all_images, $old_images);

        echo '<h2>lisätään</h2>';
        
        var_dump($new_images);

        if (empty($new_images) == false)
            $this->db->put_images_to_db($new_images);
        echo '</pre>';
    }

}

?>
