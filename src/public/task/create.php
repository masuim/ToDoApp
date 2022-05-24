<?php 
require_once __DIR__ . '/../../vendor/autoload.php';

use App\Lib\Session;
use App\Infrastructure\Redirect\Redirect;
use App\Infrastructure\Dao\CategoriesDao;
use App\Infrastructure\Dao\TasksDao;
use App\Infrastructure\Dao\Dao;

$session = Session::getInstance();

$userId = $_SESSION['user']['id'];

if(empty($userId)) {
  Redirect::handler(__DIR__. '/user/signin.php');
}

$categoriesDao = new CategoriesDao();
$getCategories = $categoriesDao->selectCategories($userId);

if(isset($_POST["selectCategory"])) {
  $selectCategory = filter_input(INPUT_POST, 'selectCategory',FILTER_SANITIZE_SPECIAL_CHARS);
}

if (isset($_POST['createTask'])) {
  if(!empty($_POST['addTask'])) {
    if(!empty($_POST['date'])) {
      $contents = filter_input(INPUT_POST, 'addTask',FILTER_SANITIZE_SPECIAL_CHARS);
      $deadline = filter_input(INPUT_POST, 'date',FILTER_SANITIZE_SPECIAL_CHARS);
      $categoriesDao = new CategoriesDao();
      $categoryId = $categoriesDao->selectCategoryId($selectCategory);
      if($categoryId) {
        $id = $categoryId["id"];
      } else {
        $categoriesDao = new CategoriesDao();
        $id = $categoriesDao->createCategory($selectCategory, $userId);
      }
      Redirect::handler("store.php?userId=$userId & contents=$contents & id=$id & deadline=$deadline");
    }
  } else {
    $error = "未入力の項目があります";
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
    <title>タスク新規作成</title>
  </head>
  <body>
    <header>
      <?php require_once __DIR__ . '/../../app/Lib/header.php'; ?>
    </header>
    <div class="h-screen flex justify-center items-center">
      <div class="flex justify-center">
        <form action="" method="post">
          <h1 class="flex justify-center text-2xl text-gray-800 mb-10">タスク登録</h1>
          <?php if (isset($error)): ?>
            <p class="text-red-600 mb-5"><?php echo $error; ?></p>
          <?php endif; ?>
          <div class="mb-10">
            <a class="text-green-500" href="./../category/index.php">カテゴリを追加</a>
          </div>
          <div class="flex">
            <select name="selectCategory" class="rounded mr-5 text-gray-500 border-2 border-gray-700">
              <option value=""><?php echo "カテゴリーを選んでください"; ?></option>
                <?php foreach ( $getCategories as $value ) : ?>
                  <option class="text-right" value="<?php echo $value["name"]; ?>" name="categoryName"><?php echo $value["name"]; ?></option>
                <? endforeach; ?>
            </select>
            <input class="border-gray-700 rounded h-5 w-60 p-4 mr-5 border-2 border-gray-700 text-gray-500" type="text" name="addTask" placeholder="タスクを入力してください">
            <input class="border-gray-700 rounded h-5 w-50 p-4 mr-5 border-2 border-gray-700 text-gray-500" type="date" name="date">
            <button name="createTask" type="submit" class="bg-indigo-400 hover:bg-indigo-700 text-white  py-2 px-4 rounded">追加</button>
          </div>
        </form>
      <div>
    </div>
  </body>
</html>