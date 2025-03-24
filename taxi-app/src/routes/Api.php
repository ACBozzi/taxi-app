<?php

use Slim\Factory\AppFactory;
use App\Controllers\AccountController;

require __DIR__ . '/../vendor/autoload.php';

$pdo = require __DIR__ . '/../config/database.php';
$accountRepository = new \App\Repositories\AccountRepository($pdo);
$accountController = new AccountController($accountRepository);

$app = AppFactory::create();

$app->post('/signup', [$accountController, 'signup']);

$app->run();
