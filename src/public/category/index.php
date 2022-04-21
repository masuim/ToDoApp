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
    <div class="bg-gray-200 w-full h-screen flex justify-center items-center">
      <div class="w-1/2 h-2/3 bg-white pt-10 pb-10 rounded-xl">   
        <h2 class="mb-2 px-2 text-4xl font-bold">カテゴリー一覧</h2> 
        <div>
        </div>
          <form action="" method="get">
            <?php if ($errors): ?>
              <?php foreach ($errors as $error): ?>
                  <p class="text-red-600"><?php echo $error; ?></p>
              <?php endforeach; ?>
            <?php endif; ?>
            <div class="block ">
              <input class="border-black h-5 w-50 p-4 border-2 bg-white" type="text" name="categoryName">
              <button name="createCategoryButton" type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">登録</button>
            </div>
            <table class="table-auto">
              <?php if ($categories): ?>
                <?php foreach ($categories as $value): ?>
                <tbody>
                  <tr>
                    <td><?php echo $value['name']; ?></td>
                    <td>
                      <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 m-1 rounded"><a href="edit.php?id=<?php echo $value[
                          'id'
                      ]; ?>">編集</a></button>
                    </td>
                    <td>
                      <button class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded"><a href="delete.php?id=<?php echo $value[
                          'id'
                      ]; ?>">削除</a></button>
                    </td>
                  </tr>
                <?php endforeach; ?>
              <?php endif; ?>
            </table>
          </form>
          <div>
            <a class="text-blue-600" href="/index.php">戻る</a>
          </div>
      </div>
    </div>
  </body>
</html>
