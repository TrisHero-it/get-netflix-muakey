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
        $accounts = $this->getAllAccounts();
        $categoryController = new CategoryController();
        $categories = $categoryController->getAllCategories();
        require_once "views/accounts/index.php";
    }

    public function store()
    {
        if ($_FILES['excel_file']['name'] == '') {
            $email = $_POST['email'];
            $password = $_POST['password'];
            $code2fa = $_POST['code_2fa'];
            $code = $this->randomString();
            $category = $_POST['category_id'];
            $this->insert($email, $password, $code2fa, $code, $category);
        } else {
            $fileTmpPath = $_FILES['excel_file']['tmp_name'];
            $spreadsheet = IOFactory::load($fileTmpPath);
            $sheet = $spreadsheet->getActiveSheet();
            $data = $sheet->toArray();
            foreach ($data as $item) {
                $this->insert($item[0], $item[1], $item[2], $this->randomString(), $item[3]);
            }
        }

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

        $result = $conn->query("SELECT * FROM accounts");
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

        $row = 2;
        while ($data = $result->fetch_assoc()) {
            $sheet->setCellValue("A{$row}", $data['id']);
            $sheet->setCellValue("B{$row}", $data['email']);
            $sheet->setCellValue("C{$row}", $data['password']);
            $sheet->setCellValue("D{$row}", $data['code_2fa']);
            $sheet->setCellValue("E{$row}", base_url . "?id=" . $data['code']);
            $row++;
        }

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="trideptrai.xlsx"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }
}
