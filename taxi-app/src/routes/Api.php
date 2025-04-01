<?php

use Slim\Factory\AppFactory;
use AnnaBozzi\TaxiApp\controllers\AccountController;

require __DIR__ . '/../vendor/autoload.php';

$pdo = require __DIR__ . '/../config/database.php';
$accountRepository = new \AnnaBozzi\TaxiApp\repositories\AccountRepository($pdo);
$accountController = new AccountController($accountRepository);

$app = AppFactory::create();

$app->post('/signup', [$accountController, 'signup']);
$app->get('/account/{id}', [$accountController, 'getAccount']);

$app->run();
