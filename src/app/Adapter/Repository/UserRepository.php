<?php
namespace App\Adapter\Repository;

require_once __DIR__ . '/../../../vendor/autoload.php';

use App\Infrastructure\Dao\UserDao;
use App\Domain\ValueObject\User\NewUser;

final class UserRepository
{
    /**
     * @var UserDao
     */
    private $userDao;

    public function __construct()
    {
        $this->userDao = new UserDao();
    }

    public function insert(NewUser $user): void
    {
        $this->userDao->createUser(
            $user->name()->value(),
            $user->email()->value(),
            $user->password()->value()
        );
    }
}
