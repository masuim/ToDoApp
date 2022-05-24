<?php
require_once __DIR__ . '/../../vendor/autoload.php';

use App\Lib\Session;

$session = Session::getInstance();
$errors = $session->popAllErrors();
$formInputs = $session->getFormInputs();

$userName = $formInputs['userName'] ?? '';
$mail = $formInputs['mail'] ?? '';
?>

<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>アカウントの作成</title>
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
  </head>
  <body class="bg-indigo-100 w-full h-screen flex justify-center items-center">
    <div class="w-96 bg-white pt-10 pb-10 rounded-xl">
      <div class="w-60 m-auto text-center">
        <h2 class="text-2xl text-gray-700 pb-5">会員登録</h2>
        <?php if ($errors): ?>
          <?php foreach ($errors as $error): ?>
            <p class="text-red-600"><?php echo $error; ?></p>
          <?php endforeach; ?>
        <?php endif; ?>
        <form action="./signup_complete.php" method="POST">
          <p><input class='border-2 border-gray-300 w-full mb-5' placeholder="User name" type=“text” name="userName" required value="<?php echo $userName; ?>"></p>
          <p><input class='border-2 border-gray-300 w-full mb-5' placeholder="Email" type=“mail” name="mail" required value="<?php echo $mail; ?>"></p>
          <p><input class='border-2 border-gray-300 w-full mb-5' placeholder="Password" type="password" name="password"></p>
          <p><input class='border-2 border-gray-300 w-full mb-5' placeholder="Password確認" type="password" name="confirmPassword"></p>
          <button class='bg-indigo-400 hover:bg-indigo-700 text-white py-1 px-2 rounded mb-5 w-full' type="submit">アカウント作成</button>
        </form>
        <a class="text-indigo-600" href="./signin.php">ログイン画面へ</a>
      </div>
    </div>
  </body>
</html>