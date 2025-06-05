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

    public function addGuideTopic($title, $link, $categoryId)
    {
        $query = "INSERT INTO guide_topics (title, link, category_id) VALUES ('$title', '$link', '$categoryId')";
        return $this->getData($query, false);
    }

    public function deleteGuideTopic($id)
    {
        $query = "DELETE FROM guide_topics WHERE id = $id";
        return $this->getData($query, false);
    }
}
