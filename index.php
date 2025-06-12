<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Muakey 2fa</title>
    <link rel="shortcut icon" href="css/logo/favicon.ico" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/style.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>

<body>
    <?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    require_once 'controllers/CodeController.php';
    require_once 'controllers/AccountController.php';
    require_once 'controllers/CategoryController.php';
    require_once 'controllers/GuideTopicController.php';
    require_once 'controllers/InforOrderController.php';
    require_once 'vendor/autoload.php';
    $codeController = new CodeController();
    $accountController = new AccountController();
    $categoryController = new CategoryController();
    $guideTopicController = new GuideTopicController();
    $inforOrderController = new InforOrderController();
    $action = $_GET['act'] ?? 'index';
    $ip = $codeController->getClientIP();
    if ($ip == '1.54.23.126' || $ip == '127.0.0.1') {
        switch ($action) {
            case 'add':
                $accountController->add();
                break;
            case 'store':
                $accountController->store();
                break;
            case 'list':
                $accountController->index();
                break;
            case 'edit':
                $accountController->edit();
                break;
            case 'show':
                $accountController->show();
                break;
            case 'update':
                $accountController->update();
                break;
            case "delete":
                $accountController->delete();
                break;
            case "replace":
                $accountController->replace();
                break;
            case "export":
                $accountController->export();
                break;
            case "categories":
                $categoryController->index();
                break;
            case "add-category":
                $categoryController->add();
                break;
            case "store-category":
                $categoryController->store();
                break;
            // Hướng dẫn
            case "guide-topics":
                $guideTopicController->index();
                break;
            case "add-guide-topic":
                $guideTopicController->add();
                break;
            case "index2":
                $codeController->index2();
                break;
            case "store-guide-topic":
                $guideTopicController->store();
                break;
            case "delete-guide-topic":
                $guideTopicController->delete();
                break;
            case "exportFormAddAccount":
                $accountController->exportFormAddAccount();
                break;
            case "exportFormAddGuideTopic":
                $accountController->exportFormAddGuideTopic();
                break;
            case "infor-orders":
                $inforOrderController->index();
                break;
            case "add-infor-orders":
                $inforOrderController->add();
                break;
            case "store-infor-orders":
                $inforOrderController->store();
                break;
            default:
                $codeController->index();
                break;
        }
    } else {
        switch ($action) {
            case "index2":
                $codeController->index2();
                break;
            case "infor-orders":
                $inforOrderController->index();
                break;
            case "add-infor-order":
                $inforOrderController->add();
                break;
            default:
                $codeController->index();
                break;
        }
    }
    ?>

</body>

</html>