<?php
require_once "models/Account.php";

class CodeController extends Account
{

    public function index()
    {
        $code = $_GET['id'] ?? 11111111;
        $account = $this->getAccountByCode($code);

        require_once "views/index.php";
    }

    function getClientIP()
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            // IP từ proxy
            return $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            // IP forwarded từ proxy load balancer
            return $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            // IP trực tiếp
            return $_SERVER['REMOTE_ADDR'];
        }
    }
}
