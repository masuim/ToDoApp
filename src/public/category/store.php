<?php
require_once __DIR__ . '/../../vendor/autoload.php';

use App\Infrastructure\Redirect\Redirect;
use App\Infrastructure\Dao\CategoriesDao;

$userId = $_GET['userId'];
$categoryName = $_GET['name'];

$categoriesDao = new CategoriesDao();
$categoriesDao->createCategory($categoryName, $userId);

Redirect::handler('index.php');
