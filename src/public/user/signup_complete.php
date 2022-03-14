<?php
require_once __DIR__ . '/../../vendor/autoload.php';

use App\Lib\Session;
use App\Lib\SessionKey;
use App\UseCase\UseCaseInteractor\SignUpInteractor;
use App\UseCase\UseCaseInput\SignUpInput;
use App\Domain\ValueObject\User\UserName;
use App\Domain\ValueObject\Email;
use App\Domain\ValueObject\InputPassword;
use App\Infrastructure\Redirect\Redirect;

$mail = filter_input(INPUT_POST, 'mail');
$userName = filter_input(INPUT_POST, 'userName');
$password = filter_input(INPUT_POST, 'password');
$confirmPassword = filter_input(INPUT_POST, 'confirmPassword');

try {
    $session = Session::getInstance();
    if (empty($password) || empty($confirmPassword)) {
        $session->appendError('パスワードを入力してください');
    }
    if ($password !== $confirmPassword) {
        $session->appendError('パスワードが一致しません');
    }

    if ($session->existsErrors()) {
        $formInputs = [
            'mail' => $mail,
            'userName' => $userName,
        ];
        $formInputsKey = new SessionKey(SessionKey::FORM_INPUTS_KEY);
        $session->setFormInputs($formInputsKey, $formInputs);
        Redirect::handler('./signup.php');
    }

    $userName = new UserName($userName);
    $userEmail = new Email($mail);
    $userPassword = new InputPassword($password);
    $useCaseInput = new SignUpInput($userName, $userEmail, $userPassword);
    $useCase = new SignUpInteractor($useCaseInput);
    $useCaseOutput = $useCase->handler();

    if (!$useCaseOutput->isSuccess()) {
        throw new Exception($useCaseOutput->message());
    }
    $_SESSION['message'] = $useCaseOutput->message();
    Redirect::handler('./signin.php');
} catch (Exception $e) {
    $session->appendError($e->getMessage());
    $_SESSION['user']['name'] = $name;
    $_SESSION['user']['email'] = $email;
    Redirect::handler('./signup.php');
}
