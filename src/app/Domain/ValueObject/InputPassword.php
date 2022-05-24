<?php
namespace App\Domain\ValueObject;

use Exception;
use App\Domain\ValueObject\HashedPassword;

/**
 * ユーザーが入力したパスワード用のValueObject
 */
final class InputPassword
{
    /**
     * パスワードの書式の正規表現
     * 半角英小文字大文字数字をそれぞれ1種類以上含む8文字以上100文字以下の正規表現
     */
    const PASSWORD_REGULAR_EXPRESSIONS = '/\A(?=.*?[a-z])(?=.*?[A-Z])(?=.*?\d)[a-zA-Z\d]{8,100}+\z/';

    /**
     * パスワードの書式が不正な場合のエラーメッセージ
     */
    const INVALID_MESSAGE = 'パスワードは半角英小文字と大文字、数字を各1種類以上含む8〜100文字で登録してください';

    /**
     * @var string
     */
    private $value;

    /**
     * コンストラクタ
     *
     * @param string $value
     */
    public function __construct(string $value)
    {
        if ($this->isInvalid($value)) {
            throw new Exception(self::INVALID_MESSAGE);
        }

        $this->value = $value;
    }

    /**
     * @return string
     */
    public function value(): string
    {
        return $this->value;
    }

    /**
     * ユーザーが入力したパスワードをハッシュ化したパスワードに変換する
     *
     * @return HashedPassword
     */
    public function hash(): HashedPassword
    {
        return new HashedPassword(
            password_hash($this->value, PASSWORD_DEFAULT)
        );
    }

    /**
     * パスワードが正しいかどうかを判定する
     *
     * @param string $value
     * @return boolean
     */
    private function isInvalid(string $value): bool
    {
        return !preg_match(self::PASSWORD_REGULAR_EXPRESSIONS, $value);
    }
}
