<?php
namespace App\UseCase\UseCaseInput;

use App\Domain\ValueObject\User\UserName;
use App\Domain\ValueObject\Email;
use App\Domain\ValueObject\InputPassword;

/**
 * ユーザー登録ユースケースの入力値
 */
final class SignUpInput
{
    /**
     * @var UserName
     */
    private $name;

    /**
     * @var Email
     */
    private $email;

    /**
     * @var InputPassword
     */
    private $password;

    /**
     * コンストラクタ
     *
     * @param UserName $name
     * @param Email $email
     * @param InputPassword $password
     */

    public function __construct(
        UserName $name,
        Email $email,
        InputPassword $password
    ) {
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
    }

    /**
     * @return UserName
     */
    public function name(): UserName
    {
        return $this->name;
    }

    /**
     * @return Email
     */
    public function email(): Email
    {
        return $this->email;
    }

    /**
     * @return InputPassword
     */
    public function password(): InputPassword
    {
        return $this->password;
    }
}
