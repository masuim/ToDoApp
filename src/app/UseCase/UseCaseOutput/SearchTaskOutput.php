<?php
namespace App\UseCase\UseCaseOutput;
require_once __DIR__ . '/../../../vendor/autoload.php';

/**
 * メモ曖昧検索＋並び替え結果表示のコントローラ
 */
final class SearchTaskOutput
{
    /**
     * @var SearchTask[]
     */
    private $searchTask;
    /**
     * コンストラクタ
     */
    public function __construct($searchTask)
    {
        $this->searchTask = $searchTask;
    }

    /**
     *
     *
     * @return SearchTask[]
     */
    public function handler(): array
    {
        return $this->searchTask;
    }
}
