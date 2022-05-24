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

$word = '%%';
if (isset($_POST['searchWord']) || (isset($_POST['order']))) {
  $word = '%' . $_POST['searchWord'] . '%';  
  $searchWord = new SearchWord($word);
  $searchTaskInput = new SearchTaskInput($searchWord);
  $searchTaskInteractor = new SearchTaskInteractor($searchTaskInput, $direction);
  $searchTaskPresenter = new SearchTaskPresenter($searchTaskInteractor->handler());
  $taskForWeb = $searchTaskPresenter->createTaskView();
}

if (!empty($_POST['selectCategory'])) {
  $categoryName = $_POST['selectCategory'];
  $categoriesDao = new CategoriesDao();
  $getCategoryId = $categoriesDao->selectCategoryId($categoryName);
  $getCategoryId = (int)$getCategoryId["id"];
  $tasksDao = new TasksDao();
  $taskForWeb = $tasksDao->selectCategories($userId, $getCategoryId);
}

$changeIsComplete = NULL;
if(isset($_POST['isComplete'])){
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
  <body class="text-gray-700">
    <header>
      <?php require_once __DIR__ . '/../app/Lib/header.php'; ?>
    </header>
    <div class="text-xs w-4/5 bg-white ml-20 mr-20 mt-10 pl-10 py-10 justify-center items-center rounded-lg shadow-xl">
      <form action="" method="post">
        <div class="inline">
          <input class="border-gray-700 h-5 w-50 p-4 mx-5 border-2 rounded" type="textarea" name="searchWord" placeholder="タスク名キーワード入力" value="<?php echo $search ??
              ''; ?>">
        </div>
        <div class="inline mr-5">
          <label><input type="radio" name="order" value="asc">締切日が近い順</label>
          <label><input type="radio" name="order" value="desc">締切日が遠い順</label>
        </div>
        <div class="inline mr-5">
          <select name="selectCategory">
            <option value=""><?php echo "カテゴリ"; ?></option>
            <?php foreach ( $getCategories as $value ) : ?>
              <option class="text-right" value="<?php echo $value["name"]; ?>" name="categoryName"><?php echo $value["name"]; ?></option>
            <? endforeach; ?>
          </select>
        </div>      
        <div class="mb-5 mr-5 inline">
          <label><input type="radio" name="isComplete" value="inComplete">未完了</label>
          <label><input type="radio" name="isComplete" value="complete">完了</label>
        </div>
        <button type="submit" class="inline bg-indigo-400 hover:bg-indigo-700 text-white mt-1 mr-5 py-1 px-4 rounded">検索・並び替え・絞り込み</button>
        <button type="submit" class="inline border border-indigo-700 text-indigo-400 hover:bg-indigo-200 text-white mt-1 py-1 px-4 rounded">全件表示に戻す</button>
      </form>
    </div>
    <div class="ml-20 mr-20 mt-10 justify-center items-center">
      <div>
        <button class="text-green-500 py-3 px-4"><a href="./task/create.php">タスクを追加</a></button>
      </div>
      <div class="flex justify-center">
        <table class="table-auto">
          <thead>
            <tr class="bg-indigo-50">
              <th class="px-4 py-2 border">タスク名</th>
              <th class="px-4 py-2 border">締め切り</th>
              <th class="px-4 py-2 border">カテゴリー名</th>
              <th class="px-4 py-2 border ">完了未完了</th>
              <th class="px-4 py-2 border">編集</th>
              <th class="px-4 py-2 border">削除</th>
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
                    <td class="border px-4 py-2 text-indigo-600">
                      <a href='__DIR__."/../task/updateStatus.php?id=<?php echo $task['id']; ?>&status=<?php echo $task["status"]; ?>" '>未完了</a>
                    </td>
                  <?php endif; ?>
                  <?php if ($task["status"] == 1) : ?>
                    <td class="border px-4 py-2 text-indigo-600 text-opacity-50">
                      <a href='__DIR__."/../task/updateStatus.php?&id=<?php echo $task['id']; ?>&status=<?php echo $task["status"]; ?>" '>完了</a>
                    </td>
                  <?php endif; ?>              
                  <td class="border px-4 py-2">
                    <button class="bg-indigo-400 hover:bg-indigo-700 text-white py-3 px-4 m-1 rounded">
                      <a href="./task/edit.php?taskId=<?php echo $task['id']; ?>">編集</a>
                    </button>
                  </td>
                  <td class="border px-4 py-2">
                    <button class="bg-red-400 hover:bg-red-600 text-white py-3 px-4 rounded">
                      <a href="./task/delete.php?taskId=<?php echo $task['id']; ?>">削除</a>
                    </button>
                  </td>
                </tr>
              </tbody>
            <?php endforeach; ?>
          <?php endif; ?>
        </table>
      </div>
    </div> 
  </body>
</html>
