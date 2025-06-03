<?php

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

require_once "models/Category.php";

class CategoryController extends Category
{
    public function add()
    {
        require_once "views/categories/add.php";
    }

    public function index()
    {
        $categories = $this->getAllCategories();
        require_once "views/categories/index.php";
    }

    public function store()
    {
        $name = $_POST['name'];
        $this->addCategory($name);
        header("Location: ?act=categories");
    }
}
