<?php
namespace App\Infrastructure\Dao;

require_once __DIR__ . '/../../../vendor/autoload.php';

use \PDO;
use App\Infrastructure\Dao\Dao;

/**
 * ユーザー情報を操作するDao
 */
final class UserDao extends Dao
{
    /**
     * DBのテーブル名
     */
    const TABLE_NAME = 'users';

    /**
     * ユーザーを追加する
     * @param string $userName
     * @param string $mail
     * @param string $password
     *
     * @return void
     */
    public function createUser(
        string $userName,
        string $mail,
        string $password
    ): void {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $sql = sprintf(
            'INSERT INTO 
		%s (name, email, password) 
	VALUES 
		(:name, :email, :password)',
            self::TABLE_NAME
        );
        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(':name', $userName, PDO::PARAM_STR);
        $statement->bindValue(':email', $mail, PDO::PARAM_STR);
        $statement->bindValue(':password', $hashedPassword, PDO::PARAM_STR);
        $statement->execute();
    }

    /**
     * ユーザー情報を取得する（email一致するもの）
     * @param string $mail
     *
     * @return array | null
     */
    public function findUserByMail(string $mail): ?array
    {
        $sql = sprintf(
            'SELECT * FROM %s WHERE email = :email',
            self::TABLE_NAME
        );
        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(':email', $mail, PDO::PARAM_STR);
        $statement->execute();
        $user = $statement->fetch(PDO::FETCH_ASSOC);

        return $user ? $user : null;
    }
}
