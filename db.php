<?php


class DB {

    private $host = "127.0.0.1";
    private $user = "root";
    private $password = "";
    private $dbase = "book";
    private $link = null;

    function __construct() {
        $this->link = new mysqli($this->host, $this->user, $this->password, $this->dbase);
        $this->link->set_charset("utf8");
    }

    public static function createDatabase($host, $user, $password, $dbase) {
        $link = new mysqli($host, $user, $password);
        $sql = "CREATE DATABASE " . $dbase . " CHARACTER SET utf8 COLLATE utf8_general_ci";
        $result = $link->query($sql);

        if (count($link->error_list) > 0) {
            echo "Базата вече е създадена";
        }
    }

    function getAll($table, $where = null, $orderBy = null, $limit = null) {

        $sql = "SELECT * FROM " . $table . $where . $orderBy;
        $result = $this->link->query($sql);
        $result_array = [];
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $result_array[] = $row;
            }
        }
        $data = print_r($result_array,true);
      /*  include_once 'functions.php';
        log2file($sql); */
        return $result_array;
    }

    function query($sql) {

        $result = $this->link->query($sql);

        if (strpos($sql, "INSERT") > -1 || strpos($sql, "UPDATE") > -1||strpos($sql, "DELETE")>-1) {
            return;
        }

        $result_array = [];
        try {
            while ($row = $result->fetch_assoc()) {

                $result_array[] = $row;
            }
        } catch (Exception $e) {
            
        }
       // $this->link->close();
        return $result_array;
    }

}
