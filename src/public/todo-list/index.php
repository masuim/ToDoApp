<?php
require_once __DIR__ . '/../../vendor/autoload.php';

use App\Lib\Session;
use App\Infrastructure\Redirect\Redirect;
use App\Infrastructure\Dao\TasksDao;

$session = Session::getInstance();
if (!isset($_SESSION['user']['id'])) {
    Redirect::handler('./user/signin.php');
}

$userId = $_SESSION['user']['id'];
$name = $_SESSION['user']['name'];

$tasksDao = new TasksDao();
$taskDate = $tasksDao->selectTasks($userId);

if (isset($_GET['isComplete'])) {
    $status = filter_input(INPUT_GET, 'isComplete',FILTER_SANITIZE_SPECIAL_CHARS);
    if ($status == 0) {
        $isComplete = '未完了';
        $changeIsComplete = '完了';
    }
    if ($status == 1) {
        $isComplete = '完了';
        $changeIsComplete = '未完了';
    }
    $tasksDao = new TasksDao();
    $taskDate = $tasksDao->selectForEachStatusTasks($status, $userId);
    
}

$direction = 'desc';
if (isset($_GET['order'])) {
    $direction = filter_input(INPUT_GET, 'order',FILTER_SANITIZE_SPECIAL_CHARS);
}

$contentsWord = '%%';
if (isset($_GET['searchWord'])) {
  $searchWord = filter_input(INPUT_GET, 'searchWord',FILTER_SANITIZE_SPECIAL_CHARS);
  $contentsWord = '%' . $searchWord . '%';  
}

if ($_GET['order'] || $_GET['searchWord']) {
    $tasksDao = new TasksDao();
    $taskDate = $tasksDao->sortAndSearchTasks(
        $userId,
        $direction,
        $contentsWord
    );
}

if (isset($_GET['categoryId'])) {
    $userId = filter_input(INPUT_GET, 'userId',FILTER_SANITIZE_SPECIAL_CHARS);
    $getCategoryId = filter_input(INPUT_GET, 'categoryId',FILTER_SANITIZE_SPECIAL_CHARS);

    $tasksDao = new TasksDao();
    $taskDate = $tasksDao->selectCategories($userId, $getCategoryId);
}

if (isset($_GET['display'])) {
  $tasksDao = new TasksDao();
  $taskDate = $tasksDao->selectAllTasks($userId);
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
    <?php require_once __DIR__ . '/../../app/Lib/header.php'; ?>
  </header>
  <div class="bg-white ml-20 mr-20 mt-10 justify-center items-center">
    <form action="" method="get">
      <div class="mb-5">
        <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" name="isComplete"><a href="./index.php?isComplete=0">未完了</a></button>
        <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" name="isComplete"><a href="./index.php?isComplete=1">完了</a></button>
      </div>
    
      <div>
        <input class="border-black h-5 w-50 p-4 border-2 bg-white" type="textarea" name="searchWord" placeholder="キーワードを入力" value="<?php echo $search ??
            ''; ?>">
        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">検索</button>
      </div>
    </form>

    <div>
      <button class="text-blue-500 py-3 px-4"><a href="./index.php?order=asc">締切昇順</a></button>
      <button class="text-blue-500 py-3 px-4"><a href="./index.php?order=desc">締切降順</a></button>
    </div>

    <h2 class="mb-2 px-2 text-4xl font-bold"><?php echo $isComplete .
        'タスク一覧'; ?></h2> 
    <?php if (isset($_GET['categoryId'])): ?>
      <a href="./index.php?display='full'">全件表示にもどす</a>
    <? endif; ?>
    <table class="table-auto">
      <thead>
        <tr>
          <th class="px-4 py-2">タスク名</th>
          <th class="px-4 py-2">締め切り</th>
          <th class="px-4 py-2">カテゴリー</th>
        </tr>
      </thead>
      <?php if ($taskDate): ?>
        <?php foreach ($taskDate as $date): ?>
          <tbody>
            <tr>
              <td class="border px-4 py-2"><?php echo $date['contents']; ?></td>
              <td class="border px-4 py-2"><?php echo $date['deadline']; ?></td>
              <td class="border px-4 py-2 text-blue-500"><a href="./index.php?categoryId=<?php echo $date[
                  'category_id'
              ]; ?>
              &userId=<?php echo $date['user_id']; ?>"><?php echo $date[
    'name'
]; ?></a></td>
              <?php if ($changeIsComplete): ?>
                <td>
                  <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded">
                    <a href='__DIR__."/../updateStatus.php?changeIsComplete=<?php echo $changeIsComplete; ?>&id=<?php echo $date[
    'id'
]; ?>&status=<?php echo $status; ?>" '>
                      <?php echo $changeIsComplete; ?>
                    </a>
                  </button>
                </td>
              <?php endif; ?>
              <td><button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-3 px-4 m-1 rounded"><a href="./edit.php?taskId=<?php echo $date[
                  'id'
              ]; ?>">編集</a></button></td>
              <td><button class="bg-red-500 hover:bg-red-700 text-white font-bold py-3 px-4 rounded"><a href="./delete.php?taskId=<?php echo $date[
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
