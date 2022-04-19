<?php
namespace App\UseCase\UseCaseInput;

require_once __DIR__ . '/../../../vendor/autoload.php';
use App\Domain\ValueObject\Task\SearchWord;

final class SearchTaskInput
{
    private $searchWord;

    public function __construct(SearchWord $searchWord)
    {
        $this->searchWord = $searchWord;
    }

    public function handler(): SearchWord
    {
        return $this->searchWord;
    }
}
