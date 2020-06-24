<?php

class Connection {

    private $con;

    public function __construct($dbname) {
        $host = "localhost";
        $user = "root";
        $pass = "";
        $options = array(
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8,sql_mode="NO_BACKSLASH_ESCAPES"'
        );

        try {
            $conn = new PDO('mysql:host='.$host.';dbname=' . $dbname, $user, $pass, $options);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            $this->con = $conn;
        } catch (PDOException $e) {
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }
    }

    public function __destruct() {
        $this->con = null;
    }

    public function query($sql, $data) {
        $array = array();
        $pdo = $this->con->prepare($sql);
        $pdo->execute($data);

        while ($row = $pdo->fetch(PDO::FETCH_BOTH)) {
            $array[] = $row;
        }


        if (empty($array)) {
            return null;
        } else {
            return $array;
        }
    }

}

?>
