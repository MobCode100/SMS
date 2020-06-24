<?php

class Connection
{
    private $con;

    public function __construct()
    {
        $server         = "localhost";
        $db_username    = "sms_2r2mart";
        $db_password    = "system";
        $service_name   = "XE";
        $sid            = "XE";
        $port           = 1521;
        $dbtns          = "(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = $server)(PORT = $port)) (CONNECT_DATA = (SERVICE_NAME = $service_name) (SID = $sid)))";

        try {
            $conn = new PDO('oci:dbname=' . $dbtns  . ';charset=UTF8', $db_username, $db_password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            $this->con = $conn;
        } catch (PDOException $e) {
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }
    }

    public function __destruct()
    {
        $this->con = null;
    }

    public function query($sql, $data)
    {
        $array = array();
        $pdo = $this->con->prepare($sql);
        $pdo->execute($data);

        if ($pdo->columnCount() != 0) {
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
}
