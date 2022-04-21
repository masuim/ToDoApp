<?php
namespace App\UseCase\UseCaseInteractor;

require_once __DIR__ . '/../../../vendor/autoload.php';
use App\Adapter\QueryServise\SearchTaskQueryServise;
use App\UseCase\UseCaseInput\searchTaskInput;
use App\UseCase\UseCaseOutput\SearchTaskOutput;

final class SearchTaskInteractor
{
    private $searchTaskQueryServise;
    private $searchTaskInput;
    private $direction;

    public function __construct(
        SearchTaskInput $searchTaskInput,
        string $direction
    ) {
        $this->searchTaskQueryServise = new SearchTaskQueryServise();
        $this->searchTaskInput = $searchTaskInput;
        $this->direction = $direction;
    }

    public function handler(): SearchTaskOutput
    {
        if ($this->hasSearchWord($this->searchTaskInput)) {
            $task = $this->searchTaskQueryServise->creatTaskDataBySearchWord(
                $this->searchTaskInput,
                $this->direction
            );
            $searchTaskOutput = new SearchTaskOutput($task);
            return $searchTaskOutput;
        }
        $task = $this->searchTaskQueryServise->selectTaskData();
        $searchTaskOutput = new SearchTaskOutput($task);
        return $searchTaskOutput;
    }

    private function hasSearchWord($searchTaskInput): bool
    {
        return $searchTaskInput->handler()->hasSearchWord();
    }
}
