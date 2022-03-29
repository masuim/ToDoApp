<?php
require_once __DIR__ . '/../../vendor/autoload.php';

use App\Lib\Session;
use App\Infrastructure\Redirect\Redirect;
use App\Infrastructure\Dao\CategoriesDao;
use App\Infrastructure\Dao\TasksDao;

$session = Session::getInstance();

$userId = $_SESSION['user']['id'];

if (empty($userId)) {
    Redirect::handler(__DIR__ . '/user/signin.php');
}

$taskId = filter_input(INPUT_GET, 'taskId',FILTER_SANITIZE_SPECIAL_CHARS);

$tasksDao = new TasksDao();
$taskDate = $tasksDao->selectTasksForId($taskId);


$categoriesDao = new CategoriesDao();
$selectCategoryName = $categoriesDao->selectCategoryName($taskDate[0] ["category_id"]);

$getCategories = $categoriesDao->selectCategories($userId);

if (isset($_POST['editTaskButton'])) {
    if(empty($_POST['editTask'])) {
      $error = '更新に失敗しました。タスクを確認してください';
      if(empty($_POST['editDate'])) {
        $error = '更新に失敗しました。日付を確認してください';
      }
    } else {
      $contents = filter_input(INPUT_POST, 'editTask',FILTER_SANITIZE_SPECIAL_CHARS);
      $editdeadline = filter_input(INPUT_POST, 'editDate',FILTER_SANITIZE_SPECIAL_CHARS);
      
      $today = date("Y-m-d");

      if($editdeadline < $today) {
        $error = "今日より前の日付が入力されています。日付を修正してください";
      } else {
        Redirect::handler("update.php?contents=$contents &editdeadline=$editdeadline &taskId=$taskId");
      }
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
    <title>タスク編集</title>
  </head>
  <body>
    <header>
      <?php require_once __DIR__ . '/../../app/Lib/header.php'; ?>
    </header>
    <div class="bg-gray-200 w-full h-screen flex justify-center items-center">
      <div class="w-4/5  bg-white pt-10 pb-10 rounded-xl">
        <div class="w-full">
          <form action="" method="post">
            <?php if ($error): ?>
              <p class="text-red-600"><?php echo $error; ?></p>
            <?php endif; ?>
            <div class="flex">
              <select name="selectCategory">
               
                <option class="text-right" value="<?php echo $selectCategoryName["name"]; ?>" name="categoryName" selected><?php echo $selectCategoryName["name"]; ?></option>
                <?php foreach ( $getCategories as $value ) : ?>
                  <option class="text-right" value="<?php echo $value["name"]; ?>" name="categoryName"><?php echo $value["name"]; ?></option>
                <? endforeach; ?>
              </select>
              <input class="border-black h-5 w-50 p-4 border-2 bg-white" type="text" name="editTask" value="<?php echo $taskDate[0][
                  'contents'
              ]; ?>">
              <input class="border-black h-5 w-50 p-4 border-2 bg-white" type="date" name="editDate" value="<?php echo $taskDate[0][
                  'deadline'
              ]; ?>">
              <button name="editTaskButton" type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">更新</button>
            </div>
          </form>
          <div>
            <a class="text-blue-600 ml-20" href="./../index.php">戻る</a>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>