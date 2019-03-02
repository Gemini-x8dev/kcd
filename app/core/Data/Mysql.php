<?php

namespace HCM\Data;

use mysqli;

class Mysql
{
    public function addVisit()
    {
        $servername = "db";
        $username = "root";
        $password = "root";
        $dbname = "root";

// Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "SELECT * from visits where session='{$_SERVER['HTTP_HOST']}'";

        $results = $conn->query($sql);

        $array = mysqli_fetch_assoc($results);

        if (empty($array)) {
            $sql = "INSERT INTO visits (session, count) VALUES ('". $_SERVER['HTTP_HOST'] ."', 0)";
            if ($conn->query($sql) === TRUE) {
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }else{

            $count = $array['count'] + 1;

            $sql = "update visits set count ={$count} where session = '{$_SERVER['HTTP_HOST']}'";

            if ($conn->query($sql) === TRUE) {
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }

        $sql = "SELECT * from visits";

        $results = $conn->query($sql);

        $array = mysqli_fetch_assoc($results);

        echo "<br><br>From Mysql: {$array['session']} was visited {$array['count']} times<br><br>";
        $conn->close();
    }
}