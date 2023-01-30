<?php

require_once 'config/Connect.php';

class CreateTable
{
    private $conn;

    public function __construct()
    {
        $this->conn = new Connect();
    }

    public function create_users_table()
    {
        if (!$this->conn->getConnection()) {
            echo "Error : Unable to open database";
        } else {
            $result = pg_query($this->conn->getConnection(), "CREATE TABLE users (
                id serial PRIMARY KEY,
                name varchar(255) NOT NULL,
                email varchar(255) NOT NULL UNIQUE,
                password varchar(255) NOT NULL,
                status varchar(255) NULL,
                created_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
                updated_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
                );");
            echo "Create table Users successfully";
        }
    }
}
