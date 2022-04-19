<?php
namespace App\Domain\ValueObject\Category;

require_once __DIR__ . '/../../../../vendor/autoload.php';

use App\Domain\ValueObject\Category\CategoryName;
use App\Domain\ValueObject\User\UserId;

/**
 * カテゴリー名の新規登録ValueObject
 */
final class NewCategory
{
    /**
     * @var CategoryName
     */
    private $categoryName;

    /**
     * @var UserId
     */
    private $userId;

    public function __construct(CategoryName $categoryName, UserId $userId)
    {
        $this->categoryName = $categoryName;
        $this->userId = $userId;
    }

    /**
     * @return CategoryName
     */
    public function categoryName(): CategoryName
    {
        return $this->categoryName;
    }

    /**
     * @return UserId
     */
    public function userId(): UserId
    {
        return $this->userId;
    }
}
