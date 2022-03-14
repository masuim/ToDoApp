<?php
require_once __DIR__ . '/../../vendor/autoload.php';

use App\Infrastructure\Redirect\Redirect;
use App\Infrastructure\Dao\TasksDao;

$contents = $_GET['contents'];
$editdeadline = $_GET['editdeadline'];
$taskId = $_GET['taskId'];

$tasksDao = new TasksDao();
$tasksDao->updateTask($contents, $editdeadline, $taskId);
Redirect::handler('./../index.php');
