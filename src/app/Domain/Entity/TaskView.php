<?php
namespace App\Domain\Entity;

use App\Domain\ValueObject\Task\Status;
use App\Domain\ValueObject\Task\Contents;
use App\Domain\ValueObject\Task\Deadline;
use App\Domain\Entity\Category;

/**
 * トップページのタスクの一覧表示機能で使用するEntity
 */
final class TaskView
{
    /**
     * @var Status
     */
    private $status;

    /**
     * @var Contents
     */
    private $contents;

    /**
     * @var Deadline
     */
    private $deadline;

    /**
     * @var Category
     */
    private $category;

    /**
     * コンストラクタ
     *
     * @param Status $status
     * @param Contents $contents
     * @param Deadline $deadline
     * @param Category $category
     *
     */

    public function __construct(
        Status $status,
        Contents $contents,
        Deadline $deadline,
        Category $category
    ) {
        $this->status = $status;
        $this->contents = $contents;
        $this->deadline = $deadline;
        $this->category = $category;
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
     * @return Deadline
     */
    public function deadline(): Deadline
    {
        return $this->deadline;
    }

    /**
     * @return Category
     */
    public function category(): Category
    {
        return $this->category;
    }
}
