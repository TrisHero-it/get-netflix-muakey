<?php
require_once "models/InforOrder.php";

class InforOrderController extends InforOrder
{
    public function index()
    {
        $inforOrders = $this->getAllInforOrders();
        require_once "views/infor-orders/index.php";
    }

    public function add()
    {
        require_once "views/infor-orders/add.php";
    }

    public function store()
    {
        $inforOrder = $_POST['infor-order'];
        $lines = explode("\n", $inforOrder);
        $data = [];

        foreach ($lines as $line) {
            [$key, $value] = explode(':', $line, 2);
            $key = trim($key);
            $value = trim($value);
            $data[$key] = $value;
        }

        $json = json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

        $this->addInforOrder($json);
        header("Location: ?act=infor-orders");
    }
}
