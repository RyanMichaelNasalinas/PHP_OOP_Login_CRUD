<?php 

include "config.php";
include "crud.php";

    class Database extends Crud {

        protected $connect;
       
        public function __construct() {
            $this->database();
        }

        public function escape_string($string) {
            return $this->connect->escape_string($string);
        }

        public function database() {
            $this->connect = new Mysqli(DB[0],DB[1],DB[2],DB[3]);

            if ($this->connect->error) {
                die('Connection Error ' . $this->connect->errno . $this->connect->error);
            }         
        }
         
        public function query($sql) {

          $query = $this->connect->query($sql);
          return $query;
        }
    }

$database = new Database;








?>