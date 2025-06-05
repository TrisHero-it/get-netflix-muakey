<?php
require_once "db.php";
class Account extends db
{

    public function getAllAccounts()
    {
        $query = "SELECT * FROM accounts where account_id is null order by shipments desc";
        return $this->getData($query);
    }

    public function getLastShipments()
    {
        $query = "SELECT shipments FROM accounts ORDER BY shipments DESC LIMIT 1";
        return $this->getData($query, false);
    }

    public function getAccountByAccountId($accountId)
    {
        $query = "SELECT * FROM accounts WHERE account_id = $accountId";
        return $this->getData($query);
    }

    public function getLatestAccountByAccountId($accountId)
    {
        $query = "SELECT accounts.id, accounts.account_id, accounts.category_id, categories.name, accounts.code, accounts.created_at, accounts.email, accounts.password, accounts.code_2fa, accounts.user, accounts.pin_code FROM accounts join categories on accounts.category_id = categories.id WHERE account_id = $accountId ORDER BY id DESC LIMIT 1";
        return $this->getData($query, false);
    }

    public function getAccountByEmailAndType($email, $type)
    {
        $query = "SELECT * FROM accounts WHERE email = '$email' AND type = '$type'";
        return $this->getData($query, false);
    }

    public function insert($email, $password, $code2fa, $code, $category, $user, $shipment = 1, $pin = null, $account_id = null)
    {
        $query = "INSERT INTO accounts (email, password, code_2fa, code, category_id, user, shipments, pin_code, account_id) 
        VALUES ('$email', '$password', $code2fa , '$code', '$category', '$user', '$shipment', $pin, $account_id)";
        $this->getData($query, false);
    }

    public function deleteAccount($id)
    {
        $query = "DELETE FROM accounts WHERE id = $id";
        $this->getData($query, false);
    }

    public function getAccountByCode($code)
    {
        $query = "SELECT accounts.id, accounts.account_id, accounts.category_id, categories.name, accounts.code, accounts.created_at, accounts.email, accounts.password, accounts.code_2fa, accounts.user, accounts.pin_code FROM accounts join categories on accounts.category_id = categories.id WHERE accounts.code = '$code'";
        return $this->getData($query, false);
    }

    public function getAccountById($id)
    {
        $query = "SELECT * FROM accounts WHERE id = $id";
        return $this->getData($query, false);
    }

    public function updateAccount($id, $email, $password, $code2fa, $category, $user, $pin = null)
    {
        $query = "UPDATE accounts SET email = '$email', password = '$password', code_2fa = $code2fa, category_id = '$category', user = '$user', pin_code = $pin WHERE id = $id";
        $this->getData($query, false);
    }
}
