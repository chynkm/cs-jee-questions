<?php

class Db
{
    private $conn;

    public function __construct()
    {
        // Create connection
        $conn = new mysqli('localhost', 'root', '', 'jee');
        // Check connection
        if ($conn->connect_error) {
            die("MySQL Connection failed: " . $conn->connect_error);
        }

        $this->conn = $conn;
    }

    public function insert($table, $colArray, $valArray)
    {
        $sql = "INSERT INTO $table $colArray VALUES $valArray";
        if($this->conn->query($sql)){
            return true;
        } else{
            die("ERROR: Could not able to execute $sql. " . mysqli_error($this->conn));
        }
    }

    public function getSubjectsAsList()
    {
        $sql = "SELECT id, name FROM subjects";
        $result = $this->conn->query($sql);

        $data = array();
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $data[$row['id']] = $row['name'];
            }
        }

        return $data;
    }
}
