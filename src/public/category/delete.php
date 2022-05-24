<?php
require_once __DIR__ . '/../../vendor/autoload.php';

use App\Lib\Session;
use App\Infrastructure\Redirect\Redirect;
use App\Infrastructure\Dao\CategoriesDao;
use App\Infrastructure\Dao\TasksDao;

$session = Session::getInstance();

$categoryId = (int) filter_input(
    INPUT_GET,
    'id',
    FILTER_SANITIZE_SPECIAL_CHARS
);
$userId = $_SESSION['user']['id'];

$tasksDao = new TasksDao();
$taskDate = $tasksDao->selectCategories($userId, $categoryId);

if ($taskDate) {
    $session->appendError(
        '削除しようとしているカテゴリーを使用しているタスクがあるため、削除できません'
    );
    Redirect::handler('index.php?error');
} else {
    $categoriesDao = new CategoriesDao();
    $categoriesDao->deleteCategory($categoryId);
}

Redirect::handler('index.php');
