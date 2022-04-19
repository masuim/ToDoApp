<?php
namespace App\Domain\ValueObject\Task;

require_once __DIR__ . '/../../../../vendor/autoload.php';

use App\Domain\ValueObject\User\UserId;
use App\Domain\ValueObject\Task\Status;
use App\Domain\ValueObject\Task\Contents;
use App\Domain\ValueObject\Category\CategoryId;
use App\Domain\ValueObject\Task\Deadline;

/**
 * タスクの新規登録ValueObject
 */
final class NewTask
{
    /**
     * @var UserId
     */
    private $userId;

    /**
     * @var Status
     */
    private $status;

    /**
     * @var Contents
     */
    private $contents;

    /**
     * @var CategoryId
     */
    private $categoryId;

    /**
     * @var Deadline
     */
    private $deadline;

    public function __construct(
        UserId $userId,
        Status $status,
        Contents $contents,
        CategoryId $categoryId,
        Deadline $deadline
    ) {
        $this->userId = $userId;
        $this->status = $status;
        $this->contents = $contents;
        $this->categoryId = $categoryId;
        $this->contents = $deadline;
    }

    /**
     * @return UserId
     */
    public function userId(): UserId
    {
        return $this->userId;
    }

    /**
     * @return Status
     */
    public function status(): Status
    {
        return $this->status;
    }

    /**
     * @return Contents
     */
    public function contents(): Contents
    {
        return $this->contents;
    }

    /**
     * @return CategoryId
     */
    public function categoryId(): CategoryId
    {
        return $this->categoryId;
    }

    /**
     * @return Deadline
     */
    public function deadline(): Deadline
    {
        return $this->deadline;
    }
}
