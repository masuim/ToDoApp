<?php
namespace App\Domain\ValueObject\Task;

use Exception;
/**
 * タスクのステータス用のValueObject
 */
final class Status
{
    const STATUS_VALUE1 = 1;
    const STATUS_VALUE0 = 0;
    const INVALID_MESSAGE = 'ステータスは0か1でお願いします！';

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
     * タスクのステータスのバリデーション
     *
     * @param string $value
     * @return boolean
     */
    private function isInvalid(string $value): bool
    {
        return $value === 0 || $value === 1;
    }
}
