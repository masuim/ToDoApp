<?php
namespace App\Adapter\ViewModel;
require_once __DIR__ . '/../../../vendor/autoload.php';
use App\Infrastructure\Dao\TasksDao;
use App\UseCase\UseCaseOutput\SearchTaskOutput;

/**
 *
 */
final class SearchTaskViewModel
{
    /**
     * @var SearchTaskOutput
     */
    private $searchTaskOutput;

    /**
     * コンストラクタ
     */
    public function __construct(SearchTaskOutput $searchTaskOutput)
    {
        $this->searchTaskOutput = $searchTaskOutput;
    }

    /**
     *
     *
     * @return ?array
     */
    public function convertToWebView(): ?array
    {
        $taskEntityList = $this->searchTaskOutput->handler();
        $taskForWeb = [];
        $taskForWeb = $this->createTaskForWeb($taskEntityList);
        return $taskForWeb;
    }

    private function createTaskForWeb($taskEntityList)
    {
        foreach ($taskEntityList as $key => $taskEntity) {
            $taskForWeb[$key]['status'] = $taskEntity->status()->value();
            $taskForWeb[$key]['contents'] = $taskEntity->contents()->value();
            $taskForWeb[$key]['deadline'] = $taskEntity->deadline()->value();
            $taskForWeb[$key]['name'] = $taskEntity
                ->category()
                ->categoryName()
                ->value();
        }
        return $taskForWeb;
    }
}
