<?php
namespace App\Domain\ValueObject\Task;

use Exception;
/**
 * タスクのcontents用のValueObject
 */
final class Contents
{
    const MAX_WORDCOUNT = 200;
    const INVALID_MESSAGE = 'タスクは200文字以下でお願いします';

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
     * タスクのcontentsのバリデーション
     *
     * @param string $value
     * @return boolean
     */
    private function isInvalid(string $value): bool
    {
        return mb_strlen($value) > 200;
    }
}
