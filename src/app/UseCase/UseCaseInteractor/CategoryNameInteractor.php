<?php
namespace App\UseCase\UseCaseInteractor;

use App\Adapter\QueryServise\CategoryNameQueryServise;
use App\Adapter\Repository\CategoryNameRepository;
use App\UseCase\UseCaseInput\CategoryNameInput;
use App\UseCase\UseCaseOutput\CategoryNameOutput;
use App\Domain\ValueObject\Category\NewCategory;
use App\Domain\Entity\Category;

/**
 * カテゴリー登録ユースケース
 */
final class CategoryNameInteractor
{
    /**
     * 同じユーザーの中に同じカテゴリーが存在している場合のエラーメッセージ
     */
    const ALLREADY_EXISTS_MESSAGE = 'すでに登録済みのカテゴリーです';

    /**
     * カテゴリー登録成功時のメッセージ
     */
    const COMPLETED_MESSAGE = '登録が完了しました';

    /**
     * @var CategoryNameRepository
     */
    private $categoryNameRepository;

    /**
     * @var CategoryNameQueryServise
     */
    private $categoryNameQueryServise;

    /**
     * @var CategoryNameInput
     */
    private $categoryNameInput;

    /**
     * コンストラクタ
     *
     * @param CategoryNameInput $input
     */
    public function __construct(CategoryNameInput $input)
    {
        $this->categoryNameRepository = new CategoryNameRepository();
        $this->categoryNameQueryServise = new CategoryNameQueryServise();
        $this->input = $input;
    }

    /**
     * カテゴリー登録処理
     * すでに存在するカテゴリーの場合はエラーとする
     *
     * @return CategoryNameOutput
     */
    public function handler(): CategoryNameOutput
    {
        $category = $this->findCategory();
        if ($this->existsCategory($category)) {
            return new CategoryNameOutput(false, self::ALLREADY_EXISTS_MESSAGE);
        } else {
            $this->createCategory();
            return new CategoryNameOutput(true, self::COMPLETED_MESSAGE);
        }
    }

    /**
     * 入力されたカテゴリー名で検索する
     *
     * @return array
     */
    private function findCategory(): ?Category
    {
        return $this->categoryNameQueryServise->findCategory(
            $this->input->categoryName(),
            $this->input->userId()
        );
    }

    /**
     * カテゴリーが存在するかどうか
     *
     * @param array|null $category
     * @return boolean
     */
    private function existsCategory(?Category $category): bool
    {
        return !is_null($category);
    }

    /**
     * カテゴリーを登録する
     *
     * @return void
     */
    private function createCategory(): void
    {
        $this->categoryNameRepository->insert(
            new NewCategory(
                $this->input->categoryName(),
                $this->input->userId()
            )
        );
    }
}
