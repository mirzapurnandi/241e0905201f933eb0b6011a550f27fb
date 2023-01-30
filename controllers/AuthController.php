<?php

require_once 'config/Connect.php';
require_once 'config/MailConnect.php';

class AuthController
{
    private $conn;

    public function __construct()
    {
        $this->conn = new Connect();
    }

    public function testing_connect()
    {
        if (!$this->conn->getConnection()) {
            echo "Error : Unable to open database\n";
        } else {
            echo "Opened database successfully\n";
        }
    }

    public function register($data)
    {
        try {
            $message = '';
            $status = 200;
            $result = null;
            if (!isset($data['name'])) {
                http_response_code(401);
                $message = 'Field Name harus diisi';
                $status = 401;
            } elseif (!isset($data['email'])) {
                http_response_code(401);
                $message = 'Field Email harus diisi';
                $status = 401;
            } elseif (!isset($data['password'])) {
                http_response_code(401);
                $message = 'Field Password harus diisi';
                $status = 401;
            }

            if ($status == 200) {
                http_response_code(201);
                $password = md5($data['password']);
                $insert = pg_query($this->conn->getConnection(), "INSERT INTO users (name, email, password) VALUES ('" . $data['name'] . "', '" . $data['email'] . "', '" . $password . "') RETURNING *");
                $message = 'Successfully insert data';
                $response = pg_fetch_array($insert, 0);
                $sendMail = new MailConnect();
                $sending = $sendMail->sendMail();
                $result = [
                    'name' => $response['name'],
                    'email' => $response['email'],
                    'password' => $response['password'],
                    'status' => $response['status'],
                    'sendMail' => $sending
                ];
            }

            echo json_encode([
                'error' => false,
                'status' => $status,
                'message' => $message,
                'result' => $result
            ]);
        } catch (\Throwable $th) {
            echo json_encode([
                'error' => true,
                'status' => $th->getCode(),
                'message' => $th->getMessage()
            ]);
        }
    }

    public function __destruct()
    {
        $this->conn->closeConnection();
    }
}
