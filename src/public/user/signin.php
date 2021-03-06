<?php
require_once __DIR__ . '/../../vendor/autoload.php';

use App\Lib\Session;

$session = Session::getInstance();
$errors = $session->popAllErrors();
$successRegistedMessage = $session->getMessage();
?>

<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>login</title>
        <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
    </head>
    <body class="bg-indigo-100 w-full h-screen flex justify-center items-center">
        <div class="w-96  bg-white pt-10 pb-10 rounded-xl">
            <div class="w-60 m-auto text-center">
                <h2 class="text-2xl text-gray-700 mb-5">ログイン</h2>
                <h3 class="mb-5 text-xl"><?php echo $successRegistedMessage; ?></h3>
                <?php if (!empty($errors)): ?>
                    <?php foreach ($errors as $error): ?>
                        <p class="text-red-600"><?php echo $error; ?></p>
                    <?php endforeach; ?>
                <?php endif; ?>
                <form class="px-4" action="./signin_complete.php" method="POST">
                    <p><input class="border-2 border-gray-300 mb-5 w-full" type=“text” name="mail" type="mail" required placeholder="Email" ></p>
                    <p><input class="border-2 border-gray-300 mb-5 w-full" type="password" placeholder="Password" name="password"></p>
                    <button class="bg-indigo-400 hover:bg-indigo-700 text-white  py-1 px-2 rounded mb-5 w-full" type="submit">ログイン</button>
                </form>
                <a class="text-indigo-500" href="./signup.php">アカウントを作る</a>
                <div class="text-gray-400 w-60 m-auto text-center pt-10">
                    <h4>テスト用アカウント</h4>
                    <p>Email : suzuki@suzuki.com</p>
                    <p>Password : Suzuki123</p>
                    <p>name : suzuki</p>
                </div>
            </div>
        </div>
    </body>
</html>