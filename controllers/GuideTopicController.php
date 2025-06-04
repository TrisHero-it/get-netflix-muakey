<?php

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
        $title = $_POST['title'];
        $content = $_POST['content'];
        $categoryId = $_POST['category_id'];
        $this->addGuideTopic($title, $content, $categoryId);
        header("Location: ?act=guide-topics&id=" . $categoryId);
    }
}
