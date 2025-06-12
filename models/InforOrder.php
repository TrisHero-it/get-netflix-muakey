<?php

require_once "db.php";
class InforOrder extends db
{
    public function getAllInforOrders()
    {
        $query = "SELECT * FROM infor_order";
        return $this->getData($query);
    }

    public function addInforOrder($inforOrder)
    {
        $query = "INSERT INTO infor_order (json) VALUES ('$inforOrder')";
        return $this->getData($query, false);
    }

    public function getInforOrderById($id)
    {
        $query = "SELECT * FROM infor_order WHERE id = $id";
        return $this->getData($query, false);
    }
}
