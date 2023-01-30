<?php

require_once 'vendor/autoload.php';
require_once 'config/Connect.php';
require_once 'config/MailConnect.php';
require_once 'config/RedisConnect.php';

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class AuthController
{
    private $conn;
    private $key;

    public function __construct()
    {
        $this->conn = new Connect();
        $this->key = 'kasdjakswer832823nkwernkwejbdskdfjsbdwesdfsd324nddf';
    }

    public function testing_connect()
    {
        if (!$this->conn->getConnection()) {
            echo "Error : Unable to open database";
        } else {
            echo "Opened database successfully";
        }
    }

    public function register($data)
    {
        try {
            $message = '';
            $status = 201;
            $result = null;
            if (!isset($data['name'])) {
                $status = 401;
                http_response_code($status);
                $message = 'Field Name harus diisi';
            } elseif (!isset($data['email'])) {
                $status = 401;
                http_response_code($status);
                $message = 'Field Email harus diisi';
            } elseif (!isset($data['password'])) {
                $status = 401;
                http_response_code($status);
                $message = 'Field Password harus diisi';
            }

            if ($status == 201) {
                http_response_code($status);
                $password = md5($data['password']);
                $insert = pg_query($this->conn->getConnection(), "INSERT INTO users (name, email, password) VALUES ('" . $data['name'] . "', '" . $data['email'] . "', '" . $password . "') RETURNING *");
                $message = 'Successfully insert data';
                $response = pg_fetch_array($insert, 0);
                $sendRedis = new RedisConnect();
                $sendRedis->sendData([
                    'to' => $response['email'],
                    'name' => $response['name'],
                    'subject' => 'Success Register',
                    'message' => 'Berikut pesan yang ditampilkan'
                ]);
                // $sendMail = new MailConnect();
                // $sending = $sendMail->sendMail();
                $result = [
                    'name' => $response['name'],
                    'email' => $response['email'],
                    'password' => $response['password'],
                    'status' => $response['status'],
                    //'sendMail' => $sending
                ];
            }

            echo json_encode([
                'error' => false,
                'status' => $status,
                'message' => $message,
                'result' => $result
            ]);
        } catch (\Throwable $th) {
            http_response_code(500);
            echo json_encode([
                'error' => true,
                'status' => $th->getCode(),
                'message' => $th->getMessage()
            ]);
        }
    }

    public function login($data)
    {
        try {
            $message = '';
            $status = 200;
            $result = null;

            if (!isset($data['email'])) {
                $status = 400;
                http_response_code($status);
                $message = 'Field Email harus diisi';
            } elseif (!isset($data['password'])) {
                $status = 400;
                http_response_code($status);
                $message = 'Field Password harus diisi';
            }

            if ($status == 200) {
                http_response_code($status);
                $email = $data['email'];
                $password = md5($data['password']);
                $expired_time = time() + (15 * 60); // 15 menit
                $date   = new DateTimeImmutable();

                //check data
                $query = "SELECT * FROM users WHERE email = '$email' AND password = '$password'";
                $check = pg_query($this->conn->getConnection(), $query);
                if (pg_num_rows($check) > 0) {
                    $response = pg_fetch_array($check, 0);

                    $token = [
                        "iss" => 'http://send-mail.test',
                        "aud" => 'http://send-mail.test',
                        "iat" => $date->getTimestamp(),
                        "nbf" => $date->getTimestamp(),
                        'exp'  => $expired_time,
                        "data" => [
                            "username" => $email,
                            "name" => $response['name']
                        ]
                    ];

                    $access_token = JWT::encode($token, $this->key, 'HS256');

                    $result = [
                        'name' => $response['name'],
                        'email' => $response['email'],
                        'status' => $response['status']
                    ];
                    $message = "Login successfully";
                } else {
                    echo json_encode([
                        'error' => false,
                        'status' => 200,
                        'message' => 'Login failed',
                    ]);
                    exit;
                }
            }

            echo json_encode([
                'error' => false,
                'status' => $status,
                'message' => $message,
                'result' => $result,
                'accessToken' => $access_token
            ]);
        } catch (\Throwable $th) {
            http_response_code(500);
            echo json_encode([
                'error' => true,
                'status' => $th->getCode(),
                'message' => $th->getMessage()
            ]);
        }
    }

    public function me($jwt)
    {
        $token = explode(' ', $jwt);
        try {
            $decoded = JWT::decode($token[1], new Key($this->key, 'HS256'));
            echo json_encode($decoded);
        } catch (\Exception $th) {
            http_response_code(401);
            echo json_encode([
                'error' => true,
                'status' => 401,
                'message' => $th->getMessage(),
            ]);
        }
    }

    public function __destruct()
    {
        $this->conn->closeConnection();
    }
}
