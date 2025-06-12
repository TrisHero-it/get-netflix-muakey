<?php
require_once "models/Account.php";
require_once "models/Account2.php";

class CodeController extends Account
{
    const API_URL = "https://api.mail.tm/";

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

        // if ($account['category_id'] == 1) {
        //     $results = $this->getMailNetflix($account['email']);
        //     $account['mail'] = $results;
        // }

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

    public function getMailNetflix($email)
    {
        $multiHandle = curl_multi_init();  // Khởi tạo handle multi
        $account2 = new Account2();
        $account = $account2->getAccountByEmailAndType(strtolower($email), 'Netflix');
        if ($account != null) {
            $data = [
                'address' => $account['email'],
                'password' => $account['password']
            ];
            $token = $this->getToken($data);
            $token = isset($token) ? json_decode(json: $token)->token : 1;
            $url = self::API_URL . "messages";
            // Tạo cURL cho mỗi token
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                "Authorization: Bearer {$token}"
            ]);
            curl_setopt($ch, CURLOPT_TIMEOUT, 10);
            curl_multi_add_handle($multiHandle, $ch);  // Thêm handle vào multi handle
            $curlHandles[] = $ch;

            // Thực thi song song
            do {
                $status = curl_multi_exec($multiHandle, $active);
            } while ($status === CURLM_CALL_MULTI_PERFORM || $active);

            // Lấy kết quả
            $results = [];

            foreach ($curlHandles as $ch) {
                $results[] = curl_multi_getcontent($ch);  // Lấy kết quả của mỗi request
                curl_multi_remove_handle($multiHandle, $ch);  // Xóa handle
                curl_close($ch);  // Đóng handle cURL
            }
            $arr = [];
            foreach ($results as $result) {
                $arr = array_merge($arr, json_decode($result, true)['hydra:member']);
            }
            $results = $arr;
            usort($results, function ($a, $b) {
                return strtotime($b['createdAt']) - strtotime($a['createdAt']);
            });
            curl_multi_close($multiHandle);  // Đóng multi handle

            return $results;
        }
        return null;
    }

    public function getToken(array $accounts)
    {
        $url = 'https://api.mail.tm/token';

        // Dữ liệu cần gửi
        $data = [
            'address' => $accounts['address'],
            'password' => $accounts['password']
        ];

        // Khởi tạo CURL
        $ch = curl_init($url);

        // Thiết lập các tùy chọn
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);

        // Gửi dữ liệu JSON
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
        ]);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

        // Thực thi CURL và lấy kết quả
        $response = curl_exec($ch);

        // Đóng CURL
        curl_close($ch);
        return $response;
    }
}
