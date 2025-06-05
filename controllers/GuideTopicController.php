<?php

use PhpOffice\PhpSpreadsheet\IOFactory;

require_once "models/GuideTopic.php";
class GuideTopicController extends GuideTopic
{
    public function index()
    {
        $categoryId = $_GET['id'];
        $guideTopics = $this->getGuideTopicByCategoryId($categoryId);
        require_once "views/guide-topics/index.php";
    }

    public function add()
    {
        $categoryModel = new Category();
        $categories = $categoryModel->getAllCategories();
        require_once "views/guide-topics/add.php";
    }

    public function store()
    {
        $categoryId = $_POST['category_id'];

        if ($_FILES['file_excel']['name'] != '') {
            $fileTmpPath = $_FILES['excel_file']['tmp_name'];
            $spreadsheet = IOFactory::load($fileTmpPath);
            $sheet = $spreadsheet->getActiveSheet();
            $data = $sheet->toArray();
            foreach ($data as $item) {
                $this->addGuideTopic($item[0], $item[1], $categoryId);
            }
        } else {
            $title = $_POST['title'];
            $link = $_POST['link'];
            $this->addGuideTopic($title, $link, $categoryId);
        }


        header("Location: ?act=guide-topics&id=" . $categoryId);
    }

    public function delete()
    {
        $id = $_GET['id'];
        $categoryId = $_GET['category_id'];
        $this->deleteGuideTopic($id);
        header("Location: ?act=guide-topics&id=" . $categoryId);
    }
}
