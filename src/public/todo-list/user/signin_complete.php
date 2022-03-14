<?php
require_once __DIR__ . '/../../../vendor/autoload.php';

use App\Lib\Session;
use App\UseCase\UseCaseInput\SignInInput;
use App\UseCase\UseCaseInteractor\SignInInteractor;
use App\Domain\ValueObject\Email;
use App\Domain\ValueObject\InputPassword;
use App\Infrastructure\Redirect\Redirect;

$mail = filter_input(INPUT_POST, 'mail');
$password = filter_input(INPUT_POST, 'password');

$session = Session::getInstance();

try {
    if (empty($mail) || empty($password)) {
        throw new Exception('パスワードとメールアドレスを入力してください');
    }
    $userEmail = new Email($mail);
    $inputPassword = new InputPassword($password);
    $useCaseInput = new SignInInput($userEmail, $inputPassword);
    $useCase = new SignInInteractor($useCaseInput);
    $useCaseOutput = $useCase->handler();

    if (!$useCaseOutput->isSuccess()) {
        throw new Exception($useCaseOutput->message());
    }
    Redirect::handler('./../index.php');
} catch (Exception $e) {
    $session->appendError($e->getMessage());
    Redirect::handler('./signin.php');
}
