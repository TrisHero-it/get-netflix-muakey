<?php
require_once "db.php";
class Account extends db
{

    public function getAllAccounts()
    {
        $query = "SELECT * FROM accounts";
        return $this->getData($query);
    }

    public function getAccountByEmailAndType($email, $type)
    {
        $query = "SELECT * FROM accounts WHERE email = '$email' AND type = '$type'";
        return $this->getData($query, false);
    }

    public function insert($email, $password, $code2fa, $code, $category)
    {
        $pdo = $this->getConnect();
        $stmt = $pdo->prepare("INSERT INTO accounts (email, password, code_2fa, code, category_id) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$email, $password, $code2fa, $code, $category]);
    }

    public function deleteAccount($id)
    {
        $query = "DELETE FROM accounts WHERE id = $id";
        $this->getData($query, false);
    }

    public function getAccountByCode($code)
    {
        $query = "SELECT * FROM accounts WHERE code = '$code'";
        return $this->getData($query, false);
    }
}
