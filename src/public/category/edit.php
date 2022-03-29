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
        $error = '更新に失敗しました。カテゴリを確認してください';
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
    <div class="bg-gray-200 w-full h-screen flex justify-center items-center">
      <div class="w-1/2  bg-white pt-10 pb-10 rounded-xl">
        <div class="w-full">
          <form action="" method="post">
            <?php if ($error): ?>
              <p class="text-red-600"><?php echo $error; ?></p>
            <?php endif; ?>
            <div>
              <input class="border-black h-5 w-50 p-4 border-2 bg-white" type="text" name="updateCategory"placeholder="<?php echo $categoryName[
                  'name'
              ]; ?>">
              <button name="updateCategoryButton" type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">更新</button>
            </div>
          </form>
          <div>
            <a class="text-blue-600" href="./index.php">戻る</a>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>