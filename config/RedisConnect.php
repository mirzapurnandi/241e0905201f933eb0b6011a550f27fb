<?php
require 'vendor/autoload.php';
require_once 'config/MailConnect.php';

use Predis\Client;

class RedisConnect
{
    private $redis;

    public function __construct()
    {
        $this->redis = new Client();
    }

    public function sendData($data)
    {
        $this->redis->rpush('email_queue', json_encode([
            'to' => $data['to'],
            'name' => $data['name'],
            'subject' => $data['subject'],
            'message' => $data['message']
        ]));

        return $this->redis;
    }

    public function worker()
    {
        $sendMail = new MailConnect();
        $result = json_decode($this->redis->lpop('email_queue'), true);

        $sendMail->sendMail([
            'email' => $result['to'],
            'name' => $result['name'],
            'subject' => $result['subject'],
            'message' => $result['message'],
        ]);
    }
}
