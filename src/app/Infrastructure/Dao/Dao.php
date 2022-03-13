<?php
namespace App\Infrastructure\Dao;

use \PDO;

abstract class Dao
{
    const DB_USER = 'docker';
    const DB_PASSWORD = 'docker';
    const DB_HOST = 'mysql';
    const DB_NAME = 'todo';

    protected $pdo;

    public function __construct()
    {
        $pdoSetting = sprintf(
            'mysql:host=%s; dbname=%s; charset=utf8mb4',
            self::DB_HOST,
            self::DB_NAME
        );
        $this->pdo = new PDO($pdoSetting, self::DB_USER, self::DB_PASSWORD);
    }
}
