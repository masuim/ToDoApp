<?php
namespace App\Domain\ValueObject\Task;
use \Exception;

final class SearchWord
{
    const INVALID_MESSAGE = '検索ワードが不適切です。';

    private $value;

    public function __construct($value)
    {
        if (!$this->isInvalid($value)) {
            throw new Exception(self::INVALID_MESSAGE);
        }
        $this->value = $value;
    }

    public function value()
    {
        return $this->value;
    }

    private function isInvalid($value): bool
    {
        return is_string($value) || $value == null;
    }

    public function hasSearchWord(): bool
    {
        if ($this->value != null) {
            return true;
        }
        return false;
    }
}
