<?php
namespace App\Infrastructure\Dao;

require_once __DIR__ . '/../../../vendor/autoload.php';

use \PDO;
use App\Infrastructure\Dao\Dao;

/**
 * タスク情報を操作するDao
 */
final class TasksDao extends Dao
{
    /**
     * DBのテーブル名
     */
    const TABLE_NAME = 'tasks';

    /**
     * カテゴリーテーブルと結合して全てのタスクを取得する（ユーザーのid指定）
     * @param  int $userId
     * @return array | null
     */
    public function selectTasks(int $userId): ?array
    {
        $sql = sprintf(
            'SELECT *
        FROM `categories`
        INNER JOIN %s
        ON tasks.category_id = categories.id
        WHERE tasks.user_id = :userId',
            self::TABLE_NAME
        );

        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(':userId', $userId, PDO::PARAM_INT);
        $statement->execute();
        $taskDate = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $taskDate ? $taskDate : null;
    }

    /**
     * ステータス毎のタスクを取得する（ユーザーのid指定）
     * @param  int $status
     * @param  int $userId
     * @param   string $direction
     * @return array | null
     */
    public function selectForEachStatusTasks(
        int $status,
        int $userId,
        string $direction
    ): ?array {
        $sql = sprintf(
            "SELECT *
        FROM `categories`
        INNER JOIN %s
        ON tasks.category_id = categories.id
        WHERE tasks.status = :status
        AND tasks.user_id = :userId
        ORDER BY tasks.deadline $direction",
            self::TABLE_NAME
        );

        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(':status', $status, PDO::PARAM_INT);
        $statement->bindValue(':userId', $userId, PDO::PARAM_INT);
        $statement->execute();
        $taskForWeb = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $taskForWeb ? $taskForWeb : null;
    }

    /**
     * タスクを追加する（すでにあるカテゴリーを使う場合）
     * @param int $userId
     * @param string $contents
     * @param int $id
     * @param string $deadline
     *
     * @return void
     */
    public function createTask(
        int $userId,
        string $contents,
        int $id,
        string $deadline
    ): void {
        $sql = sprintf(
            'INSERT INTO 
  %s (user_id, contents, category_id, deadline) 
VALUES 
  (:user_id, :contents, :category_id, :deadline)',
            self::TABLE_NAME
        );
        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(':user_id', $userId, PDO::PARAM_INT);
        $statement->bindValue(':contents', $contents, PDO::PARAM_STR);
        $statement->bindValue(':category_id', $id, PDO::PARAM_INT);
        $statement->bindValue(':deadline', $deadline, PDO::PARAM_STR);
        $statement->execute();
    }

    /**
     * タスクを削除する
     * @param int $taskId
     *
     * @return void
     */
    public function deleteTask(int $taskId): void
    {
        $sql = sprintf('DELETE FROM %s WHERE id = :taskId', self::TABLE_NAME);
        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(':taskId', $taskId, PDO::PARAM_INT);
        $statement->execute();
    }

    /**
     * ステータスを更新する
     * @param int $status
     * @param int $taskId
     *
     * @return void
     */
    public function updateTaskStatus(int $status, int $taskId): void
    {
        $sql = sprintf(
            'UPDATE %s SET `status` =:status WHERE `id` =:taskId',
            self::TABLE_NAME
        );
        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(':status', $status, PDO::PARAM_INT);
        $statement->bindValue(':taskId', $taskId, PDO::PARAM_INT);
        $statement->execute();
        $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    /*タスクの並べ替えとあいまい検索
     * @param int $userId
     * @param string $direction
     * @param string $searchWord
     *
     * @return array | null
     */
    public function sortAndSearchTasks(
        int $userId,
        string $direction,
        string $searchWord
    ): ?array {
        $sql = sprintf(
            "SELECT * FROM %s INNER JOIN categories ON tasks.category_id = categories.id WHERE contents LIKE :searchWord AND
        tasks.user_id = :userId ORDER BY tasks.deadline $direction",
            self::TABLE_NAME
        );
        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(':userId', $userId, PDO::PARAM_INT);
        $statement->bindValue(':searchWord', $searchWord, PDO::PARAM_STR);
        $statement->execute();
        $taskMappers = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $taskMappers ? $taskMappers : null;
    }

    /**
     * カテゴリーを絞ったタスクを取得する（ユーザーのid指定）
     * @param  int $userId
     * @param  int $getCategoryId
     * @return array | null
     */
    public function selectCategories(int $userId, int $getCategoryId): ?array
    {
        $sql = sprintf(
            'SELECT *
        FROM %s
        INNER JOIN categories
        ON tasks.category_id = categories.id
        WHERE tasks.user_id = :userId
        AND tasks.category_id = :getCategoryId',
            self::TABLE_NAME
        );

        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(':userId', $userId, PDO::PARAM_INT);
        $statement->bindValue(':getCategoryId', $getCategoryId, PDO::PARAM_INT);
        $statement->execute();
        $taskDate = $statement->fetchAll(PDO::FETCH_ASSOC);

        return $taskDate ? $taskDate : null;
    }

    /**
     * タスクを取得する（タスクid指定）
     * @param  int $taskId
     * @return array | null
     */
    public function selectTasksForId(int $taskId): ?array
    {
        $sql = sprintf(
            'SELECT *
        FROM  %s
        WHERE id = :taskId',
            self::TABLE_NAME
        );
        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(':taskId', $taskId, PDO::PARAM_INT);
        $statement->execute();
        $taskDate = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $taskDate ? $taskDate : null;
    }

    /**
     * タスクのcontentsとdeadlineを更新する
     * @param string $contents
     * @param date $editdeadline
     * @param int $taskId
     *
     * @return void
     */
    public function updateTask(
        string $contents,
        string $editdeadline,
        int $taskId
    ): void {
        $sql = sprintf(
            'UPDATE %s SET `contents` = :contents, `deadline` =:deadline WHERE `tasks`.`id` =:taskId',
            self::TABLE_NAME
        );

        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(':contents', $contents, PDO::PARAM_STR);
        $statement->bindValue(
            ':deadline',
            date('Y-m-d', strtotime($editdeadline)),
            PDO::PARAM_STR
        );
        $statement->bindValue(':taskId', $taskId, PDO::PARAM_INT);
        $statement->execute();
    }

    /**
     * タスクを取得する（ユーザーid指定）
     * @param  int $userId
     * @param string $direction
     * @return array | null
     */
    public function sortTatsks(int $userId, string $direction): ?array
    {
        $sql = sprintf(
            "SELECT *
        FROM  %s
        WHERE user_id = :userId
        ORDER BY deadline $direction",
            self::TABLE_NAME
        );
        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(':userId', $userId, PDO::PARAM_INT);
        $statement->execute();
        $taskForWeb = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $taskForWeb ? $taskForWeb : null;
    }
}
