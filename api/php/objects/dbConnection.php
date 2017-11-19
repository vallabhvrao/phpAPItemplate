<?php

//namespace Vallabh Rao;

class DbConnectionClass {

    private $DB_HOST = "";
    private $DB_NAME = "";
    private $DB_PORT = 0;
    private $DB_USERNAME = "";
    private $DB_PASSWORD = "";
    var $PDO_SETTINGS = "";
    public $db;

    public function getDb($databaseName) {
        $this->DB_HOST = "localhost";
        $this->DB_NAME = $databaseName;
        $this->DB_PORT = 3306;
        $this->DB_USERNAME = "root";
        $this->DB_PASSWORD = "";

        if (!isset($this->db)) {
            try {
                $dsn = 'mysql:host=' . $this->DB_HOST . ';dbname=' . $this->DB_NAME . ';charset=utf8';
                $this->db = new PDO($dsn, $this->DB_USERNAME, $this->DB_PASSWORD, array(
                    PDO::ATTR_EMULATE_PREPARES => false,
                    PDO::MYSQL_ATTR_DIRECT_QUERY => false,
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
                ));
            } catch (Exception $e) {
                if ($_SESSION['DEVELOPMENT']) {
                    die('[{"status" : "error", "message" : "' . print_r($e->getMessage()) . '"}]');
                } else {
                    die('[{"status" : "error", "message" : "Unable to connect to database. Please try after some time."}]');
                }
            }
        }
        return $this->db;
    }

}
