<?php
namespace App\Infrastructure\Redirect;

/**
 * リダイレクトを行うクラス
 */
final class Redirect
{
    /**
     * 渡したパスにリダイレクトする
     *
     * @param string $path
     * @return void
     */
    public static function handler(string $path): void
    {
        header('Location:' . $path);
        exit();
    }
}
