<?php
require_once "db.php";
class Account extends db
{

    public function getAllAccounts()
    {
        $query = "SELECT * FROM accounts order by shipments desc";
        return $this->getData($query);
    }

    public function getLastShipments()
    {
        $query = "SELECT shipments FROM accounts ORDER BY shipments DESC LIMIT 1";
        return $this->getData($query, false);
    }

    public function getAccountByEmailAndType($email, $type)
    {
        $query = "SELECT * FROM accounts WHERE email = '$email' AND type = '$type'";
        return $this->getData($query, false);
    }

    public function insert($email, $password, $code2fa, $code, $category, $user, $shipment = 1, $pin = null)
    {
        $query = "INSERT INTO accounts (email, password, code_2fa, code, category_id, user, shipments, pin_code) 
        VALUES ('$email', '$password', $code2fa , '$code', '$category', '$user', '$shipment', $pin)";
        $this->getData($query, false);
    }

    public function deleteAccount($id)
    {
        $query = "DELETE FROM accounts WHERE id = $id";
        $this->getData($query, false);
    }

    public function getAccountByCode($code)
    {
        $query = "SELECT * FROM accounts join categories on accounts.category_id = categories.id WHERE accounts.code = '$code'";
        return $this->getData($query, false);
    }
}
