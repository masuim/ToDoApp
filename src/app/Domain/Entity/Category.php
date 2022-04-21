<?php
namespace App\Domain\Entity;

use App\Domain\ValueObject\Category\CategoryId;
use App\Domain\ValueObject\Category\CategoryName;
use App\Domain\ValueObject\User\UserId;

/**
 * カテゴリーのEntity
 */
final class Category
{
    /**
     * @var CategoryId
     */
    private $categoryId;

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
     * @param CategoryId $categoryId
     * @param CategoryName $categoryName
     * @param UserId $userId
     */
    public function __construct(
        CategoryId $categoryId,
        CategoryName $categoryName,
        UserId $userId
    ) {
        $this->categoryId = $categoryId;
        $this->categoryName = $categoryName;
        $this->userId = $userId;
    }

    /**
     * @return CategoryId
     */
    public function categoryId(): CategoryId
    {
        return $this->categoryId;
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
