<?php
namespace App\UseCase\UseCaseOutput;

/**
 * ログインユースケースの返り値
 */
final class SignInOutput
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
     * @param bool $isSuccess
     * @param string $message
     */
    public function __construct(bool $isSuccess, string $message)
    {
        $this->isSuccess = $isSuccess;
        $this->message = $message;
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
