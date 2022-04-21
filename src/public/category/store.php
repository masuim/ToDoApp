<?php
require_once __DIR__ . '/../../vendor/autoload.php';

use App\Lib\Session;
use App\Infrastructure\Redirect\Redirect;
use App\Infrastructure\Dao\CategoriesDao;
use App\Domain\ValueObject\User\UserId;
use App\Domain\ValueObject\Category\CategoryName;
use App\UseCase\UseCaseInput\CategoryNameInput;
use App\UseCase\UseCaseInteractor\CategoryNameInteractor;

try {
    $session = Session::getInstance();
    $userId = $_GET['userId'];
    $categoryName = $_GET['name'];
    $setUserId = new UserId($userId);
    $setCategoryName = new CategoryName($categoryName);
    $categoryNameInput = new CategoryNameInput($setCategoryName, $setUserId);
    $categoryNameInteractor = new CategoryNameInteractor($categoryNameInput);
    $useCaseOutput = $categoryNameInteractor->handler();
} catch (Exception $e) {
    $session->appendError($e->getMessage());
}

Redirect::handler('index.php');
