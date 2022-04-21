<?php
require_once __DIR__ . '/../vendor/autoload.php';

use App\Lib\Session;
use App\Infrastructure\Redirect\Redirect;
use App\Infrastructure\Dao\TasksDao;
use App\Infrastructure\Dao\CategoriesDao;
use App\Domain\ValueObject\Task\SearchWord;
use App\UseCase\UseCaseInput\SearchTaskInput;
use App\UseCase\UseCaseInteractor\SearchTaskInteractor;
use App\Adapter\Presenter\SearchTaskPresenter;

$session = Session::getInstance();
if (!isset($_SESSION['user']['id'])) {
    Redirect::handler('./../user/signin.php');
}

$userId = $_SESSION['user']['id'];
$name = $_SESSION['user']['name'];

$tasksDao = new TasksDao();
$taskForWeb = $tasksDao->selectTasks($userId);

$categoriesDao = new CategoriesDao();
$getCategories = $categoriesDao->selectCategories($userId);

$direction = 'desc';
if (isset($_POST['order'])) {
    $direction = $_POST['order'];
}

$changeIsComplete = NULL;
if($_POST['isComplete']){
  $isComplete = $_POST['isComplete'];
  if($isComplete == "inComplete") {
    $isComplete = "未完了";
    $changeIsComplete = "完了";
    $status = 0;
  }
  if($isComplete == "complete") {
    $isComplete = "完了";
    $changeIsComplete = "未完了";
    $status = 1;
  }
  $tasksDao = new TasksDao();
  $taskForWeb = $tasksDao->selectForEachStatusTasks($status, $userId, $direction); 
}



$word = '%%';
if ($_POST['order'] || $_POST['searchWord']) {
  $word = '%' . $_POST['searchWord'] . '%';  
  $searchWord = new SearchWord($word);
  $searchTaskInput = new SearchTaskInput($searchWord);
  $searchTaskInteractor = new SearchTaskInteractor($searchTaskInput, $direction);
  $searchTaskPresenter = new SearchTaskPresenter($searchTaskInteractor->handler());
  $taskForWeb = $searchTaskPresenter->createTaskView();
}

if ($_POST['selectCategory']) {
  $categoryName = $_POST['selectCategory'];
  $categoriesDao = new CategoriesDao();
  $getCategoryId = $categoriesDao->selectCategoryId($categoryName);
  $getCategoryId = (int)$getCategoryId["id"];

  $tasksDao = new TasksDao();
  $taskForWeb = $tasksDao->selectCategories($userId, $getCategoryId);
}

if (isset($_GET['categoryId'])) {
    $tasksDao = new TasksDao();
    $taskForWeb = $tasksDao->selectCategories($userId, $getCategoryId);
}
?>

<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
    <title>タスク一覧</title>
  </head>
  <body>
  <header>
    <?php require_once __DIR__ . '/../app/Lib/header.php'; ?>
  </header>

  <div class="w-4/5 bg-white ml-20 mr-20 mt-10 justify-center items-center shadow-xl">
    <form action="" method="post">
      
    
      <div class="inline">
        <input class="border-black h-5 w-50 p-4 border-2 bg-white" type="textarea" name="searchWord" placeholder="キーワードを入力" value="<?php echo $search ??
            ''; ?>">
        
      </div>
    
    <div class="inline">
      <label><input type="radio" name="order" value="asc">新しい順</label>
      <label><input type="radio" name="order" value="desc">古い順</label>
    </div>

    <div class="inline">
    <select name="selectCategory">
      <option value=""><?php echo "カテゴリ"; ?></option>
        <?php foreach ( $getCategories as $value ) : ?>
          <option class="text-right" value="<?php echo $value["name"]; ?>" name="categoryName"><?php echo $value["name"]; ?></option>
        <? endforeach; ?>
    </select>
    </div>      

    <div class="mb-5 inline">
      <label><input type="radio" name="isComplete" value="inComplete">完了</label>
      <label><input type="radio" name="isComplete" value="complete">未完了</label>
      
    </div>

    <button type="submit" class="block bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">送信</button>
        </form>
  </div>


  <div class="bg-white ml-20 mr-20 mt-10 justify-center items-center">
    
    <div>
      <button class="text-blue-500 py-3 px-4"><a href="./task/create.php">タスクを追加</a></button>
    </div>

    <table class="table-auto">
      <thead>
        <tr>
          <th class="px-4 py-2">タスク名</th>
          <th class="px-4 py-2">締め切り</th>
          <th class="px-4 py-2">カテゴリー名</th>
          <th class="px-4 py-2">完了未完了</th>
          <th class="px-4 py-2">編集</th>
          <th class="px-4 py-2">削除</th>
        </tr>
      </thead>
      <?php if ($taskForWeb): ?>
        <?php foreach ($taskForWeb as $task): ?>
          <tbody>
            <tr>
              <td class="border px-4 py-2"><?php echo $task['contents']; ?></td>
              <td class="border px-4 py-2"><?php echo $task['deadline']; ?></td>
              <td class="border px-4 py-2"><?php echo $task['name']; ?></td>
              <?php if ($task["status"] == 0) : ?>
                <td class="border px-4 py-2">
                  <a href='__DIR__."/../task/updateStatus.php?id=<?php echo $task['id']; ?>&status=<?php echo $task["status"]; ?>" '>完了</a>
                </td>
              <?php endif; ?>

              <?php if ($task["status"] == 1) : ?>
                <td class="border px-4 py-2">
                  <a href='__DIR__."/../task/updateStatus.php?&id=<?php echo $task['id']; ?>&status=<?php echo $task["status"]; ?>" '>未完了</a>
                </td>
              <?php endif; ?>              
              <td class="border px-4 py-2"><button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-3 px-4 m-1 rounded"><a href="./task/edit.php?taskId=<?php echo $task[
                  'id'
              ]; ?>">編集</a></button></td>
              <td class="border px-4 py-2"><button class="bg-red-500 hover:bg-red-700 text-white font-bold py-3 px-4 rounded"><a href="./task/delete.php?taskId=<?php echo $task[
                  'id'
              ]; ?>">削除</a></button></td>
            </tr>
          </tbody>
        <?php endforeach; ?>
      <?php endif; ?>
    </table>
            </div> 
  </body>
</html>
