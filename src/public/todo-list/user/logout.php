<?php
require_once __DIR__ . '/../../../vendor/autoload.php';

use App\Lib\Session;
use App\Infrastructure\Redirect\Redirect;

$session = Session::getInstance();

$_SESSION = [];
if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time() - 4200, '/');
}
session_destroy();
Redirect::handler('./signin.php');
