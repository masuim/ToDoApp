<?php
namespace App\Infrastructure\Dao;

require_once __DIR__ . '/../../../vendor/autoload.php';

use \PDO;
use App\Infrastructure\Dao\Dao;

/**
 * コメント情報を操作するDao
 */
final class CategoriesDao extends Dao
{
    /**
     * DBのテーブル名
     */
    const TABLE_NAME = 'categories';

    /**
     * カテゴリーを取得する(全て)
     * @param  int $userId
     * @return array | null
     */
    public function selectCategories(int $userId): ?array
    {
        $sql = sprintf(
            'SELECT * FROM %s WHERE user_id=:userId',
            self::TABLE_NAME
        );
        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(':userId', $userId, PDO::PARAM_INT);
        $statement->execute();
        $getCategories = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $getCategories ? $getCategories : null;
    }

    /**
     * カテゴリのnameを取得する（categoriesテーブルのid指定）
     * @param  int $id
     * @return array | null
     */
    public function selectCategoryName(int $id): ?array
    {
        $sql = sprintf('SELECT name FROM %s WHERE id= :id', self::TABLE_NAME);
        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(':id', $id, PDO::PARAM_INT);
        $statement->execute();
        $categoryName = $statement->fetch(PDO::FETCH_ASSOC);
        return $categoryName ? $categoryName : null;
    }

    /**
     * カテゴリのidを取得する（categoriesテーブルのname指定）
     * @param  string $selectCategory
     * @return array | null
     */
    public function selectCategoryId(string $selectCategory): ?array
    {
        $sql = sprintf('SELECT id FROM %s WHERE name= :name', self::TABLE_NAME);
        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(':name', $selectCategory, PDO::PARAM_STR);
        $statement->execute();
        $categoryId = $statement->fetch(PDO::FETCH_ASSOC);
        return $categoryId ? $categoryId : null;
    }

    /**
     * カテゴリを編集する
     * @param  int $categoryId
     * @param  string $updateCategory
     */
    public function editCategory(int $categoryId, string $updateCategory): void
    {
        $sql = sprintf(
            'UPDATE %s SET name=:name WHERE id=:id',
            self::TABLE_NAME
        );
        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(':name', $updateCategory, PDO::PARAM_STR);
        $statement->bindValue(':id', $categoryId, PDO::PARAM_INT);
        $statement->execute();
    }

    /**
     * カテゴリーを追加する
     * @param string $categoryName
     * @param int $userId
     *
     * @return void
     */
    public function createCategory(string $categoryName, int $userId): void
    {
        $sql = sprintf(
            'INSERT INTO 
		%s (name, user_id) 
	VALUES 
		(:categoryName, :user_id)',
            self::TABLE_NAME
        );
        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(':categoryName', $categoryName, PDO::PARAM_STR);
        $statement->bindValue(':user_id', $userId, PDO::PARAM_INT);
        $statement->execute();
    }

    /**
     * カテゴリーを削除する
     * @param int $categoryId
     *
     * @return void
     */
    public function deleteCategory(int $categoryId): void
    {
        $sql = sprintf("DELETE FROM %s WHERE id=$categoryId", self::TABLE_NAME);
        $statement = $this->pdo->prepare($sql);
        $statement->execute();
    }

    /**
     * カテゴリー情報を取得する（categoryName一致するもの, userId指定）
     * @param string $categoryName
     * @param int $userId
     *
     * @return array | null
     */
    public function findCategoryByName(
        string $categoryName,
        int $userId
    ): ?array {
        $sql = sprintf(
            'SELECT * FROM %s WHERE name = :categoryName AND user_id = :userId',
            self::TABLE_NAME
        );
        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(':categoryName', $categoryName, PDO::PARAM_STR);
        $statement->bindValue(':userId', $userId, PDO::PARAM_INT);
        $statement->execute();
        $categoryMapper = $statement->fetch(PDO::FETCH_ASSOC);
        return $categoryMapper ? $categoryMapper : null;
    }
}
