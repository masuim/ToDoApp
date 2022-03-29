<?php
require_once __DIR__ . '/../../vendor/autoload.php';

use App\Infrastructure\Redirect\Redirect;
use App\Infrastructure\Dao\TasksDao;

$userId = $_GET['userId'];
$contents = $_GET['contents'];
$id = $_GET['id'];
$deadline = $_GET['deadline'];

$tasksDao = new TasksDao();
$tasksDao->createTask($userId, $contents, $id, $deadline);

Redirect::handler('./../index.php');
