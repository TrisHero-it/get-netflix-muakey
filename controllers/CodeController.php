<?php
require_once "models/Account.php";

class CodeController extends Account
{

    public function index()
    {
        if ($_GET['id'] != '') {
            $code = $this->removeInvisibleChars($_GET['id']);
        } else {
            echo "<p style='color: red;'>Không tìm thấy id</p>";
            die;
        }
        $account = $this->getAccountByCode($code);
        if ($account == null) {
            echo "<p style='color: red;'>Không tìm thấy tài khoản</p>";
            die;
        }
        $account2 = $this->getLatestAccountByAccountId($account['id']);
        if ($account2 != null) {
            $account = $account2;
        }
        $guideTopicModel = new GuideTopic();
        if (isset($account['id'])) {
            $guideTopics = $guideTopicModel->getGuideTopicByCategoryId($account['category_id']);
        }

        require_once "views/index.php";
    }

    public function index2()
    {
        require_once "views/index2.php";
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

    function removeInvisibleChars($str)
    {
        // Loại bỏ ký tự điều khiển ASCII (trừ \n và \r nếu muốn giữ lại)
        $str = preg_replace('/[\x00-\x1F\x7F]/u', '', $str);

        // Loại bỏ các ký tự invisible trong Unicode như zero-width space, etc.
        $str = preg_replace('/[\x{200B}-\x{200D}\x{FEFF}]/u', '', $str);

        return $str;
    }
}
