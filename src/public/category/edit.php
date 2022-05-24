<?php
require_once __DIR__ . '/../../vendor/autoload.php';

use App\Lib\Session;
use App\Infrastructure\Redirect\Redirect;
use App\Infrastructure\Dao\CategoriesDao;

$session = Session::getInstance();

$categoryId = (int) filter_input(
    INPUT_GET,
    'id',
    FILTER_SANITIZE_SPECIAL_CHARS
);

$userId = $_SESSION['user']['id'];

if (empty($userId)) {
    Redirect::handler(__DIR__ . '/user/signin.php');
}

$categoriesDao = new CategoriesDao();
$categoryName = $categoriesDao->selectCategoryName($categoryId);

if (isset($_POST['updateCategory'])) {
    if (empty($_POST['updateCategory'])) {
        $error = 'カテゴリを入力してください';
    } else {
        $updateCategory = filter_input(
            INPUT_POST,
            'updateCategory',
            FILTER_SANITIZE_SPECIAL_CHARS
        );
        Redirect::handler(
            "update.php?categoryId=$categoryId& updateCategory=$updateCategory"
        );
    }
}
?>

<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
    <title>カテゴリー編集</title>
  </head>
  <body>
    <header>
      <?php require_once __DIR__ . '/../../app/Lib/header.php'; ?>
    </header>
    <div class="h-screen flex justify-center items-center">
      <div class="w-1/2 pt-10 pb-10 rounded-xl">
        <div class="w-full">
          <form action="" method="post">
            <h1 class="flex justify-center text-2xl text-gray-800 mb-10">カテゴリー編集</h1>
            <?php if (isset($error)): ?>
              <p class="text-red-600 mb-5"><?php echo $error; ?></p>
            <?php endif; ?>
            <div class="mb-5 text-right">
              <a class="text-indigo-600" href="./index.php">カテゴリー一覧に戻る</a>
            </div>
            <div class="flex justify-center">
              <input class="border-gray-700 h-5 w-70 p-4 mb-5 border-2 rounded" type="text" name="updateCategory"placeholder="<?php echo $categoryName[
                  'name'
              ]; ?>">
              <button name="updateCategoryButton" type="submit" class="bg-indigo-400 hover:bg-indigo-700 text-white h-9 py-2 px-4 ml-5 rounded">更新</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </body>
</html>