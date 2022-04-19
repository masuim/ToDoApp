<?php
require_once __DIR__ . '/../../vendor/autoload.php';

use App\Infrastructure\Dao\TasksDao;
use App\Infrastructure\Redirect\Redirect;

$taskId = (int) filter_input(INPUT_GET, 'id', FILTER_SANITIZE_SPECIAL_CHARS);
$statusNum = (int) filter_input(
    INPUT_GET,
    'status',
    FILTER_SANITIZE_SPECIAL_CHARS
);
if ($statusNum == 0) {
    $status = 1;
}
if ($statusNum == 1) {
    $status = 0;
}
$tasksDao = new TasksDao();
$tasksDao->updateTaskStatus($status, $taskId);

Redirect::handler('./../index.php');
