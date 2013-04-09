<?php

class mysql {

    private $local_db;
    public $dbname = "galleria";
    private $dbuser = "root";
    private $dbpw = "bitnami";
    private $dbhost = "localhost";
    public $etuliite = "galleria_";

    public function __construct() {
        $this->local_db = mysql_connect($this->dbhost, $this->dbuser, $this->dbpw)
                or die(mysql_error());
        mysql_select_db($this->dbname)
                or die(mysql_error());
    }
    
    public function exists_in_db($from, $where, $is) {
        $data_array = $this->get_query_select('*', $from, $where, $is);

        if (is_array($where) and isset($data_array[0]))
            return true;
        elseif (isset($data_array[0]) and $data_array[0][$where] !== "")
            return true;
        else
            return false;
    }
    
    public function get_query_select($what, $from, $where = null, $is = null, $order_by = null, $where_array_is_and = true) {
        $what = $this->filterParameters($what);
        $where = $this->filterParameters($where);
        $order_by = $this->filterParameters($order_by);
        $from = $this->filterParameters($from);
        $is = $this->filterParameters($is);


        $query = "SELECT " . $what . " FROM " . $this->etuliite . $from;

        if (!empty($where)) {
            if (is_array($where) and is_array($is)) {
                $query .= " WHERE " . $this->get_where_query_part_from_array($where, $is, $where_array_is_and);
            } else
                $query .= " WHERE " . $where . "='$is'";
        }

        if (!empty($order_by))
            $query .= " ORDER BY " . $order_by;

 //       echo $query;

        return $this->get_query_bulk($query);
    }
    
    public function get_query_bulk($query) {
        $result = mysql_query($query)
                or die(mysql_error());

        $n = 0;
        $template_array = array();
        while ($row = mysql_fetch_assoc($result)) {
            $template_array[$n] = $row;
            ++$n;
        };

//        var_dump($template_array);

        return $template_array;
    }
    
    public function put_query_from_array($where, $what_is_what_array) {
        $what_is_what_array = $this->filterParameters($what_is_what_array);
        $where = $this->filterParameters($where);
        $query = "INSERT INTO " . $this->etuliite . $where . " (" . implode(", ", array_keys($what_is_what_array)) . ") VALUES ('" . implode("', '", array_values($what_is_what_array)) . "')";
        
 //       echo $query;
        
        mysql_query($query)
                or die(mysql_error());
    }
    
    public function update_db($array, $table, $where = null, $is = null) {
        $array = $this->filterParameters($array);
        $table = $this->filterParameters($table);
        $where = $this->filterParameters($where);
        $is = $this->filterParameters($is);

        $query = "UPDATE " . $this->etuliite . $table . " SET ";

        $first = true;
        foreach ($array as $key => $value) {
            if (!$first)
                $query .= ", ";

            $query .= "$key='$value'";
            $first = false;
        }
        if (isset($where))
            $query .= "WHERE $where='$is'";

//        echo $query;

        mysql_query($query)
                or die(mysql_error());
    }
    
    private function filterParameters($array) {
        /*
         * Created by: Stefan van Beusekom
         * Created on: 31-01-2011
         * Description: A method that ensures safe data entry, and accepts either strings or arrays. If the array is multidimensional, 
         *                     it will recursively loop through the array and make all points of data safe for entry.
         * parameters: string or array;
         * return: string or array;
         */

        // Check if the parameter is an array
        if (is_array($array)) {
            // Loop through the initial dimension
            foreach ($array as $key => $value) {
                // Check if any nodes are arrays themselves
                if (is_array($array[$key]))
                // If they are, let the function call itself over that particular node
                    $array[$key] = $this->filterParameters($array[$key]);

                // Check if the nodes are strings
                if (is_string($array[$key]))
                // If they are, perform the real escape function over the selected node
                    $array[$key] = mysql_real_escape_string(htmlspecialchars($array[$key], ENT_QUOTES, "UTF-8"));
            }
        }
        // Check if the parameter is a string
        if (is_string($array))
        // If it is, perform a  mysql_real_escape_string on the parameter
            $array = mysql_real_escape_string(mysql_real_escape_string(htmlspecialchars($array, ENT_QUOTES, "UTF-8")));

        // Return the filtered result
        return $array;
    }
}

?>