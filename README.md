## アプリ

ToDo リスト

## 機能一覧

- ユーザー登録、ログイン機能
- タスク登録、編集、削除機能
- カテゴリー登録、編集、削除機能
- 一覧表示機能（タスク名、タスク締切日、カテゴリー名、完了未完了の表示）
- 絞り込み検索機能（「キーワード」「カテゴリー」「完了未完了」での絞込み）
- 並び替え機能（作成日の新しい順、古い順での並び替え）
- 切り替え機能（完了または未完了をクリックすると表示を切り替えることができる）

## 使用技術

- PHP
- phpMyAdmin
- Docker/Docker-compose
- tailwind

## テスト用アカウント

name : suzuki  
Email : suzuki@suzuki.com  
Password : Suzuki123

## Docker の起動

```
./docker-compose-local.sh up
```

## ページ紹介

php
[localhost:8080](http://localhost:8080)

PHPMyAdmin
[localhost:3306](http://localhost:3306)

### Docker 環境に変更があった時

```
./docker-compose-local.sh up --build
```
