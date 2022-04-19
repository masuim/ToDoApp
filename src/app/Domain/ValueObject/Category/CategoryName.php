<?php
namespace App\Domain\ValueObject\Category;

use Exception;
/**
 * カテゴリー名用のValueObject
 */
final class CategoryName
{
    const MAX_WORDCOUNT = 40;
    const INVALID_MESSAGE = 'カテゴリーは40文字以下でお願いします！';

    /**
     * @var string
     */
    private $value;

    /**
     * コンストラクタ
     *
     * @param string $value
     */
    public function __construct(string $value)
    {
        if ($this->isInvalid($value)) {
            throw new Exception(self::INVALID_MESSAGE);
            Redirect::handler(__DIR__ . '/category/index.php');
        }
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function value(): string
    {
        return $this->value;
    }

    /**
     * カテゴリーの名前のバリデーション
     *
     * @param string $value
     * @return boolean
     */
    private function isInvalid(string $value): bool
    {
        return mb_strlen($value) > 40;
    }
}
