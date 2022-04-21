<?php
namespace App\Adapter\Presenter;
require_once __DIR__ . '/../../../vendor/autoload.php';
use App\Adapter\ViewModel\SearchTaskViewModel;
use App\UseCase\UseCaseOutput\SearchTaskOutput;

/**
 * タスク絞り込み検索結果表示のコントローラ
 * あいまい検索＋締切日並び替え(降順,昇順)
 */
final class SearchTaskPresenter
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
     * タスクの全件表示処理
     *
     * @return array
     */
    public function createTaskView(): ?array
    {
        $searchTaskViewModel = new SearchTaskViewModel($this->searchTaskOutput);
        return $searchTaskViewModel->convertToWebView();
    }
}
