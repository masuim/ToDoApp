<?php
require_once __DIR__ . '/../../vendor/autoload.php';

use App\Infrastructure\Redirect\Redirect;
use App\Infrastructure\Dao\CategoriesDao;

$categoryId = $_GET['categoryId'];
$updateCategory = $_GET['updateCategory'];

$categoriesDao = new CategoriesDao();
$categoriesDao->editCategory($categoryId, $updateCategory);
Redirect::handler('./index.php');
