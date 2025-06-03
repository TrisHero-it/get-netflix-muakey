<?php
require_once "db.php";

class Category extends db
{
    public function getAllCategories()
    {
        $query = "SELECT * FROM categories";
        return $this->getData($query);
    }

    public function addCategory($name)
    {
        $query = "INSERT INTO categories (name) VALUES ('$name')";
        return $this->getData($query, false);
    }
}
