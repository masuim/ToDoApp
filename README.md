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

## 設定を変更したい

```
localhost:8080をhtmlが表示されるようにしたい -> nginx/default.conf 4行目を index index.htmlにする。
```

#

#

#

#

#

#

#

#

#

# 🐳

## 環境構築

### 1. 「tq-docker-template」リポジトリをテンプレートとして、自身の Github にリポジトリを作成

<img width="1440" alt="スクリーンショット 2021-12-24 11 05 14" src="https://user-images.githubusercontent.com/63081802/147306983-b09827a5-cdbd-4061-a1c3-390496b266a8.png">

### 2. ローカルに clone する

### 3. Docker のインストール

### 4. 「Docker の起動」と「PHP を使う準備」

```
./docker-compose-local.sh up
```

## その他コマンド

### Docker 環境に変更があった時

```
./docker-compose-local.sh up --build
```
