<?php
namespace App\UseCase\UseCaseOutput;

require_once __DIR__ . '/../../../vendor/autoload.php';

use App\Lib\Session;

/**
 * カテゴリー名登録ユースケースの出力値
 */
final class CategoryNameOutput
{
    /**
     * @var bool
     */
    private $isSuccess;

    /**
     * @var string
     */
    private $message;

    /**
     * コンストラクタ
     *
     * @param boolean $isSuccess
     * @param string $message
     */
    public function __construct(bool $isSuccess, string $message)
    {
        $this->isSuccess = $isSuccess;
        $this->message = $message;

        if (!$isSuccess) {
            $_SESSION['errors'][] = $message;
        } else {
            $_SESSION['message'][] = $message;
        }
    }

    /**
     * @return boolean
     */
    public function isSuccess(): bool
    {
        return $this->isSuccess;
    }

    /**
     * @return string
     */
    public function message(): string
    {
        return $this->message;
    }
}
