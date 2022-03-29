<?php
require_once __DIR__ . '/../../vendor/autoload.php';

use App\Infrastructure\Dao\TasksDao;
use App\Infrastructure\Redirect\Redirect;

$changeIsComplete = $_GET['changeIsComplete'];
$taskId = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_SPECIAL_CHARS);
$statusNum = filter_input(INPUT_GET, 'status', FILTER_SANITIZE_SPECIAL_CHARS);

if ($changeIsComplete == '未完了') {
    $statusNum = 0;
}
if ($changeIsComplete == '完了') {
    $statusNum = 1;
}
$tasksDao = new TasksDao();
$tasksDao->updateTaskStatus($statusNum, $taskId);

Redirect::handler('./../index.php');
