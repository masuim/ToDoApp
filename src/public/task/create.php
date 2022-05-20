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
    $error = "タスク内容または日付を入力してください";
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
    <div class="bg-gray-200 w-full h-screen flex justify-center items-center">
      <div class="w-4/5  bg-white pt-10 pb-10 rounded-xl">
        <div class="w-full flex justify-center">
          <form action="" method="post">
            <?php if (isset($error)): ?>
              <p class="text-red-600"><?php echo $error; ?></p>
            <?php endif; ?>
            <div>
              <a class="text-blue-600 ml-20" href="./../category/index.php">カテゴリを追加</a>
            </div>
            <div class="flex">
              <select name="selectCategory">
                <option value=""><?php echo "カテゴリーを選んでください"; ?></option>
                  <?php foreach ( $getCategories as $value ) : ?>
                    <option class="text-right" value="<?php echo $value["name"]; ?>" name="categoryName"><?php echo $value["name"]; ?></option>
                  <? endforeach; ?>
              </select>
              <input class="border-black h-5 w-50 p-4 border-2 bg-white" type="text" name="addTask" placeholder="タスクを追加">
              <input class="border-black h-5 w-50 p-4 border-2 bg-white" type="date" name="date">
              <button name="createTask" type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">追加</button>
            </div>
          </form>
        <div>
        <a class="text-blue-600 ml-20" href="./../index.php">戻る</a>
      </div>
    </div>
  </body>
</html>