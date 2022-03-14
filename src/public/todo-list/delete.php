<?php
require_once __DIR__ . '/../../vendor/autoload.php';

use App\Infrastructure\Redirect\Redirect;
use App\Infrastructure\Dao\TasksDao;

$taskId = filter_input(INPUT_GET, 'taskId', FILTER_SANITIZE_SPECIAL_CHARS);
$TasksDao = new TasksDao();
$TasksDao->deleteTask($taskId);

Redirect::handler('./index.php');
