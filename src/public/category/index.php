<?php
require_once __DIR__ . '/../../vendor/autoload.php';

use App\Lib\Session;
use App\Infrastructure\Redirect\Redirect;
use App\Infrastructure\Dao\CategoriesDao;

$session = Session::getInstance();
$errors = $session->popAllErrors();
$userId = $_SESSION['user']['id'];

if (empty($userId)) {
    Redirect::handler(__DIR__ . '/user/signin.php');
}

if (isset($_GET['createCategoryButton'])) {
    if (empty($_GET['categoryName'])) {
        $session->appendError('何も入力されていません');
    } else {
        $categoryName = filter_input(
            INPUT_GET,
            'categoryName',
            FILTER_SANITIZE_FULL_SPECIAL_CHARS
        );
        Redirect::handler("store.php?userId=$userId & name=$categoryName");
    }
}

if (isset($_GET['id'])) {
    $categoryId = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_SPECIAL_CHARS);
    Redirect::handler("delete.php?categoryId=$categoryId");
}

$categoriesDao = new CategoriesDao();
$categories = $categoriesDao->selectCategories($userId);
?>
  
<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
    <title>カテゴリー一覧</title>
  </head>
  <body>
    <header>
      <?php require_once __DIR__ . '/../../app/Lib/header.php'; ?>
    </header>
    <div class="h-screen flex justify-center items-center">
      <form action="" method="get">
        <h1 class="flex justify-center text-2xl text-gray-800 mb-10">カテゴリー一覧</h1>
        <?php if ($errors): ?>
          <?php foreach ($errors as $error): ?>
            <p class="text-red-600 mb-5"><?php echo $error; ?></p>
          <?php endforeach; ?>
        <?php endif; ?>
        <div class="mb-5 text-right">
          <a class="text-indigo-600" href="/task/create.php">タスク登録画面に戻る</a>
        </div>
        <div class="block">
          <input class="border-gray-700 h-5 w-80 p-4 mb-5 border-2 rounded" type="text" name="categoryName" placeholder="カテゴリーを入力してください">
          <button name="createCategoryButton" type="submit" class="bg-indigo-400 hover:bg-indigo-700 text-white  py-2 px-4 rounded">登録</button>
        </div>
        <table class="table-auto">
          <?php if ($categories): ?>
            <?php foreach ($categories as $value): ?>
              <tbody>
                <tr>
                  <td class="pr-5"><?php echo $value['name']; ?></td>
                  <td>
                    <button class="bg-indigo-400 hover:bg-indigo-700 text-white py-2 px-4 m-1 rounded"><a href="edit.php?id=<?php echo $value[
                        'id'
                    ]; ?>">編集</a></button>
                  </td>
                  <td>
                    <button class="bg-red-400 hover:bg-red-600 text-white py-2 px-4 rounded"><a href="delete.php?id=<?php echo $value[
                        'id'
                    ]; ?>">削除</a></button>
                  </td>
                </tr>
              </tbody>  
            <?php endforeach; ?>
          <?php endif; ?>
        </table>
      </form>
    </div>
  </body>
</html>
