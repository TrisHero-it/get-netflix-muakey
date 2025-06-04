<?php
require_once "db.php";
class GuideTopic extends db
{
    public function getAllGuideTopics()
    {
        $query = "SELECT * FROM guide_topics join categories on categories.id = guide_topics.category_id order by guide_topics.id desc";
        return $this->getData($query);
    }

    public function getGuideTopicByCategoryId($categoryId)
    {
        $query = "SELECT * FROM guide_topics join categories on categories.id = guide_topics.category_id where guide_topics.category_id = $categoryId order by guide_topics.id desc";
        return $this->getData($query);
    }

    public function addGuideTopic($title, $content, $categoryId)
    {
        $query = "INSERT INTO guide_topics (title, content, category_id) VALUES ('$title', '$content', '$categoryId')";
        return $this->getData($query, false);
    }
}
