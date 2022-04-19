<?php
namespace App\UseCase\UseCaseInput;

use App\Domain\ValueObject\Category\CategoryName;
use App\Domain\ValueObject\User\UserId;

/**
 * カテゴリー名登録ユースケースの入力値
 */
final class CategoryNameInput
{
    /**
     * @var CategoryName
     */
    private $categoryName;

    /**
     * @var UserId
     */
    private $userId;

    /**
     * コンストラクタ
     *
     * @param CategoryName $categoryName
     * @param UserId $userId
     */

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

    public function userId(): UserId
    {
        return $this->userId;
    }
}
