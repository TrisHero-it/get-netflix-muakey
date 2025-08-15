<?php
require_once "db.php";
class Account2 extends db
{
    public function index()
    {
        $query = "SELECT * FROM accounts ";
        if (isset($_GET['type']) && $_GET['type'] != '') {
            $query .= " WHERE type = '$_GET[type]'";
        }
        $query .= " ORDER BY id DESC";
        return $this->getData2($query);
    }

    public function getAccountByEmailAndType($email, $type)
    {
        $query = "SELECT * FROM accounts WHERE email = '$email' AND type = '$type'";
        return $this->getData2($query, false);
    }

    public function insert($email, $password, $type)
    {
        $pdo = $this->getConnect2();
        $stmt = $pdo->prepare("INSERT INTO accounts (email, password, type) VALUES (?, ?, ?)");
        $stmt->execute([$email, $password, $type]);
    }

    public function delete($id)
    {
        $query = "DELETE FROM accounts WHERE id = $id";
        $this->getData2($query, false);
    }
}
