<?php
namespace App\Adapter\Repository;

require_once __DIR__ . '/../../../vendor/autoload.php';

use App\Infrastructure\Dao\CategoriesDao;
use App\Domain\ValueObject\Category\NewCategory;

final class CategoryNameRepository
{
    /**
     * @var CategoriesDao
     */
    private $categoriesDao;

    public function __construct()
    {
        $this->categoriesDao = new CategoriesDao();
    }

    public function insert(NewCategory $category): void
    {
        $this->categoriesDao->createCategory(
            $category->categoryName()->value(),
            $category->userId()->value()
        );
    }
}
