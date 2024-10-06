<?php
$url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

include 'controllers/pessoaController.php';

switch ($url) {
    case '/':
        pessoaController::index();
        break;

    case '/pessoa/index':
        pessoaController::index();
        pessoaController::indexChildren((int)$_GET['id_pai']);
        header("Location: /");
        break;


    case '/index.php':
        if (isset($_GET['pessoa'])) {
            if ($_GET['pessoa'] === 'create') {
                pessoaController::create();
            } elseif ($_GET['pessoa'] === 'createChild') {
                pessoaController::createChild();
            } elseif ($_GET['pessoa'] === 'deleteAll') {
                pessoaController::deleteAll();
            } elseif ($_GET['pessoa'] === 'deleteChild') {
                pessoaController::deleteChild();
            }
        }
        break;

    default:
        echo "ERRO 404!";
        break;
}
