<?php

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


require_once "models/Account.php";
class AccountController extends Account
{
    public function add()
    {
        $categoryController = new CategoryController();
        $categories = $categoryController->getAllCategories();
        require_once "views/accounts/add.php";
    }

    public function index()
    {
        $limit = 20; // số bản ghi mỗi trang
        $page = isset($_GET['page']) && $_GET['page'] > 0 ? (int) $_GET['page'] : 1;
        $offset = ($page - 1) * $limit;
        if (isset($_GET['search']) && $_GET['search'] != '') {
            $search = $_GET['search'];
            $checkAccount = $this->AccountSearch($search);
            if (isset($checkAccount['account_id'])) {
                $originalAccount = $this->getAccountById($checkAccount['account_id']);
                $accounts = $this->AccountsSearch($originalAccount['email']);
            } else {
                $accounts = $this->AccountsSearch($search);
            }
        } else {
            $accounts = $this->getAccountLimit($offset, $limit);
        }

        $currentPage = isset($_GET['page']) && $_GET['page'] > 0 ? (int) $_GET['page'] : 1;
        $range = 2;

        $totalAccounts = $this->getCountAccount();
        $totalAccounts['total'] = ceil($totalAccounts['total'] / $limit);

        $categoryController = new CategoryController();
        $categories = $categoryController->getAllCategories();
        require_once "views/accounts/index.php";
    }

    public function show()
    {
        $id = $_GET['id'];
        $account = $this->getAccountById($id);
        $account2 = $this->getAccountByAccountId($account['id']);
        require_once "views/accounts/show.php";
    }

    public function store()
    {
        $shipment = $this->getLastShipments();
        $shipment = $shipment['shipments'] + 1;
        if ($_FILES['excel_file']['name'] == '') {
            $email = $_POST['email'];
            $category = $_POST['category_id'];
            $code2fa = $_POST['code_2fa'] == "" ? 'null' : "'" . $_POST['code_2fa'] . "'";
            $pin = $_POST['pin'] == "" ? 'null' : "'" . $_POST['pin'] . "'";
            $this->insert(
                $email,
                $_POST['password'],
                $code2fa,
                $this->randomString(),
                $category,
                $_POST['user'],
                $shipment,
                $pin,
                $_POST['account_id'] ?? 'null'
            );
        } else {
            $fileTmpPath = $_FILES['excel_file']['tmp_name'];
            $spreadsheet = IOFactory::load($fileTmpPath);
            $sheet = $spreadsheet->getActiveSheet();
            $data = $sheet->toArray();
            $i = 0;
            foreach ($data as $item) {
                if ($item[0] == '' || $item[0] == null) {
                    continue;
                }
                if ($i == 0) {
                    $i++;
                    continue;
                }
                $this->insert(
                    $item[0],
                    $item[1],
                    $item[2] != null ? "'" . $item[2] . "'" : 'null',
                    $this->randomString(),
                    $_POST['category_id'],
                    $item[3] ?? 1,
                    $shipment,
                    $item[4] ?? 'null',
                    "null"
                );
            }
        }

        header("Location: ?act=list");
    }

    public function replace()
    {
        $shipment = $this->getLastShipments();
        $shipment = $shipment['shipments'] + 1;
        $oldEmail = $_POST['old_email'];
        $newEmail = $_POST['new_email'];
        $newPassword = $_POST['new_password'];
        $checkAccounts = $this->getAccountsByEmail(trim($oldEmail));
        foreach ($checkAccounts as $account) {

            if ($account['code'] == null || $account['account_id'] != null) {
                $originalAccount = $this->getAccountById($account['account_id']);
                $accounts = $this->getAccountsByEmail($originalAccount['email']);
            } else {
                $accounts = $checkAccounts;
            }
            break;
        }

        foreach ($accounts as $account) {
            $data = $account;
            $data['email'] = $newEmail;
            $data['password'] = $newPassword;
            $this->insert2(
                $data['email'],
                $data['password'],
                $data['code_2fa'] == '' ? 'null' : "'" . $data['code_2fa'] . "'",
                'null',
                $data['category_id'],
                $data['user'],
                $shipment,
                $data['pin_code'] == '' ? 'null' : "'" . $data['pin_code'] . "'",
                $account['id']
            );
        }

        header("Location: ?act=list");
    }

    public function edit()
    {
        $id = $_GET['id'];
        $account = $this->getAccountById($id);
        $categoryController = new CategoryController();
        $categories = $categoryController->getAllCategories();
        $account2 = $this->getAccountByAccountId($account['id']);
        require_once "views/accounts/edit.php";
    }

    public function update()
    {
        $id = $_GET['id'];
        $this->updateAccount(
            $id,
            $_POST['email'],
            $_POST['password'],
            $_POST['code_2fa'] == '' ? 'null' : "'" . $_POST['code_2fa'] . "'",
            $_POST['category_id'],
            $_POST['user'],
            $_POST['pin'] == '' ? 'null' : "'" . $_POST['pin'] . "'"
        );

        header("Location: ?act=list");
    }

    public function delete()
    {
        $id = $_GET['id'];
        $this->deleteAccount($id);
        header("Location: ?act=list");
    }

    function randomString($length = 8)
    {
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'; // 26 chữ + 10 số = 36 ký tự
        $charactersLength = strlen($characters);
        $randomString = '';

        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[random_int(0, $charactersLength - 1)];
        }

        return $randomString;
    }

    public function export()
    {
        ini_set('display_errors', 1);
        error_reporting(E_ALL);

        if (ob_get_length()) ob_end_clean();

        $conn = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);
        if ($conn->connect_error) {
            die("Kết nối thất bại: " . $conn->connect_error);
        }

        $result = $conn->query("SELECT * FROM accounts join categories on accounts.category_id = categories.id where shipments = " . $_POST['shipments']);
        if (!$result || $result->num_rows == 0) {
            die("Không có dữ liệu hoặc lỗi SQL.");
        }

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'ID');
        $sheet->setCellValue('B1', 'Email');
        $sheet->setCellValue('C1', 'Password');
        $sheet->setCellValue('D1', 'Code 2FA');
        $sheet->setCellValue('E1', 'Code');
        $sheet->setCellValue('F1', 'Thể loại');
        $sheet->setCellValue('G1', 'User');
        $sheet->setCellValue('H1', 'Thời gian');
        $sheet->setCellValue('I1', 'Lô hàng');
        $sheet->setCellValue('J1', 'Mã Pin');


        $row = 2;
        while ($data = $result->fetch_assoc()) {
            $sheet->setCellValue("A{$row}", $data['id']);
            $sheet->setCellValue("B{$row}", $data['email']);
            $sheet->setCellValue("C{$row}", $data['password']);
            $sheet->setCellValue("D{$row}", $data['code_2fa']);
            $sheet->setCellValue("E{$row}", base_url . "?id=" . $data['code']);
            $sheet->setCellValue("F{$row}", $data['name']);
            $sheet->setCellValue("G{$row}", $data['user']);
            $sheet->setCellValue("H{$row}", $data['created_at']);
            $sheet->setCellValue("I{$row}", $data['shipments']);
            $row++;
        }

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="trideptrai.xlsx"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }


    public function exportFormAddAccount()
    {
        ini_set('display_errors', 1);
        error_reporting(E_ALL);

        if (ob_get_length()) ob_end_clean();

        $conn = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);
        if ($conn->connect_error) {
            die("Kết nối thất bại: " . $conn->connect_error);
        }

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'Email');
        $sheet->setCellValue('B1', 'Password');
        $sheet->setCellValue('C1', 'Code 2FA (Nếu có)');
        $sheet->setCellValue('D1', 'User (Nếu có)');
        $sheet->setCellValue('E1', 'Mã Pin (Nếu có)');

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="form-add-account.xlsx"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }

    public function exportFormAddGuideTopic()
    {
        ini_set('display_errors', 1);
        error_reporting(E_ALL);

        if (ob_get_length()) ob_end_clean();

        $conn = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);
        if ($conn->connect_error) {
            die("Kết nối thất bại: " . $conn->connect_error);
        }

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'Tiêu đề');
        $sheet->setCellValue('B1', 'Link');

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="form-add-guide-topic.xlsx"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }
}
