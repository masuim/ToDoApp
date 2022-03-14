<?php
namespace App\UseCase\UseCaseInteractor;

use App\Adapter\QueryServise\UserQueryServise;
use App\Adapter\Repository\UserRepository;
use App\UseCase\UseCaseInput\SignUpInput;
use App\UseCase\UseCaseOutput\SignUpOutput;
use App\Domain\ValueObject\User\NewUser;
use App\Domain\Entity\User;

/**
 * ユーザー登録ユースケース
 */
final class SignUpInteractor
{
    /**
     * メールアドレスがすでに存在している場合のエラーメッセージ
     */
    const ALLREADY_EXISTS_MESSAGE = 'すでに登録済みのメールアドレスです';

    /**
     * ユーザー登録成功時のメッセージ
     */
    const COMPLETED_MESSAGE = '登録が完了しました';

    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @var UserQueryServise
     */
    private $userQueryServise;

    /**
     * @var SignUpInput
     */
    private $input;

    /**
     * コンストラクタ
     *
     * @param SignUpInput $input
     */
    public function __construct(SignUpInput $input)
    {
        $this->userRepository = new UserRepository();
        $this->userQueryServise = new UserQueryServise();
        $this->input = $input;
    }

    /**
     * ユーザー登録処理
     * すでに存在するメールアドレスの場合はエラーとする
     *
     * @return SignUpOutput
     */
    public function handler(): SignUpOutput
    {
        $user = $this->findUser();

        if ($this->existsUser($user)) {
            return new SignUpOutput(false, self::ALLREADY_EXISTS_MESSAGE);
        }

        $this->signup();
        return new SignUpOutput(true, self::COMPLETED_MESSAGE);
    }

    /**
     * ユーザーを入力されたメールアドレスで検索する
     *
     * @return array
     */
    private function findUser(): ?User
    {
        return $this->userQueryServise->findByEmail($this->input->email());
    }

    /**
     * ユーザーが存在するかどうか
     *
     * @param array|null $user
     * @return boolean
     */
    private function existsUser(?User $user): bool
    {
        return !is_null($user);
    }

    /**
     * ユーザーを登録する
     *
     * @return void
     */
    private function signup(): void
    {
        $this->userRepository->insert(
            new NewUser(
                $this->input->name(),
                $this->input->email(),
                $this->input->password()
            )
        );
    }
}
