<?php
namespace App\Domain\ValueObject\Task;

use Exception;
/**
 * タスクの期限用のValueObject
 */
final class Deadline
{
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
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function value(): string
    {
        return $this->value;
    }
}
