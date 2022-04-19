<?php
namespace App\Adapter\QueryServise;

require_once __DIR__ . '/../../../vendor/autoload.php';

use App\Infrastructure\Dao\CategoriesDao;
use App\Domain\Entity\Category;
use App\Domain\ValueObject\Category\CategoryId;
use App\Domain\ValueObject\Category\CategoryName;
use App\Domain\ValueObject\User\UserId;

final class CategoryNameQueryServise
{
    /**
     * @var CategoriesDao
     */
    private $categoriesDao;

    public function __construct()
    {
        $this->categoriesDao = new CategoriesDao();
    }

    public function findCategory(
        CategoryName $categoryName,
        UserId $userId
    ): ?Category {
        $categoryMapper = $this->categoriesDao->findCategoryByName(
            $categoryName->value(),
            $userId->value()
        );
        return $this->notExistsCategory($categoryMapper)
            ? null
            : new Category(
                new CategoryId($categoryMapper['id']),
                new CategoryName($categoryMapper['name']),
                new UserId($categoryMapper['user_id'])
            );
    }

    private function notExistsCategory(?array $category): bool
    {
        return is_null($category);
    }
}
