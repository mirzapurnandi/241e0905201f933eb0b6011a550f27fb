<?php
class Connect
{
    private $conn;

    public function __construct()
    {
        $host = 'localhost';
        $port = '5432';
        $dbname = 'sending';
        $user = 'mirza';
        $password = '';
        $this->conn = pg_connect("host=$host port=$port dbname=$dbname user=$user password=$password");
    }

    public function getConnection()
    {
        return $this->conn;
    }

    public function closeConnection()
    {
        pg_close($this->conn);
    }
}

/* $conn = new PostgreSQLConnection("hostname", "5432", "database_name", "username", "password");
if (!$conn->getConnection()) {
    echo "Error : Unable to open database\n";
} else {
    echo "Opened database successfully\n";
}
$conn->closeConnection(); */
