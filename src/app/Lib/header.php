<!DOCTYPE html>
  <html lang="ja">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
    <title>ToDoアプリ</title>
  </head>
<header>
  <div class="w-full">
    <nav class="bg-indigo-300 text-white shadow-lg">
      <div class="md:flex items-center justify-between py-2 px-8 md:px-12">
        <div class="flex justify-between items-center">
          <div class="text-2xl  text-gray-800 md:text-3xl"></div>
        </div>
        <div class="mr-auto text-2xl">ToDoアプリ</div>
        <div class="flex flex-col md:flex-row hidden md:block -mx-2">
          <a href="http://localhost:8080/index.php" class="text-white rounded hover:bg-indigo-400 hover:text-white hover:font-medium py-2 px-2 md:mx-2">ホーム</a>
          <a href="http://localhost:8080/category/index.php" class="text-white rounded hover:bg-indigo-400 hover:text-white hover:font-medium py-2 px-2 md:mx-2">カテゴリ一覧</a>
          <a href="http://localhost:8080/user/logout.php" class="text-white rounded hover:bg-indigo-400 hover:text-white hover:font-medium py-2 px-2 md:mx-2">ログアウト</a>
        </div>
      </div>
    </nav>
  </div>
</header>
