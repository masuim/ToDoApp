<?php
namespace App\Adapter\QueryServise;

require_once __DIR__ . '/../../../vendor/autoload.php';
use App\Infrastructure\Dao\TasksDao;
use App\Domain\Entity\TaskView;
use App\Domain\Entity\Category;
use App\Domain\ValueObject\Task\TaskId;
use App\Domain\ValueObject\User\UserId;
use App\Domain\ValueObject\Task\Status;
use App\Domain\ValueObject\Task\Contents;
use App\Domain\ValueObject\Category\CategoryId;
use App\Domain\ValueObject\Task\Deadline;
use App\Domain\ValueObject\Category\CategoryName;
use App\UseCase\UseCaseInput\SearchTaskInput;

final class SearchTaskQueryServise
{
    /**
     * @var TasksDao
     */
    private $tasksDao;

    public function __construct()
    {
        $this->tasksDao = new TasksDao();
    }

    /**
     * @return Task[]
     */
    public function selectTaskData(): array
    {
        $taskMappers = $this->tasksDao->selectTasks() ?? [];
        $task = $this->createTaskData($taskMappers);
        return $task;
    }

    public function creatTaskDataBySearchWord(
        SearchTaskInput $searchTaskInput,
        $direction
    ): array {
        $userId = $_SESSION['user']['id'];
        $searchWord = $searchTaskInput->handler()->value();
        $taskMappers =
            $this->tasksDao->sortAndSearchTasks(
                $userId,
                $direction,
                $searchWord
            ) ?? [];
        $task = $this->createTaskData($taskMappers);
        return $task;
    }

    private function createTaskData(array $taskMappers): array
    {
        $task = [];
        foreach ($taskMappers as $mapper) {
            $task[] = new TaskView(
                new TaskId($mapper['id']),
                new Status($mapper['status']),
                new Contents($mapper['contents']),
                new Deadline($mapper['deadline']),
                new Category(
                    new CategoryId($mapper['category_id']),
                    new CategoryName($mapper['name']),
                    new UserId($mapper['user_id'])
                )
            );
        }
        return $task;
    }
}
