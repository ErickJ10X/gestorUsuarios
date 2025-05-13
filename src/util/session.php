<?php
class Session {
    public function __construct(){
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function set($key, $value): void
    {
        $_SESSION[$key] = $value;
    }
    public function get($key) {
        return $_SESSION[$key] ?? null;
    }
    public static function destroy(): void
    {
        $_SESSION = [];

        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params["path"],
                $params["domain"],
                $params["secure"],
                $params["httponly"]
            );
        }

        session_destroy();
    }

    public static function isAuthenticated(): bool
    {
        return isset($_SESSION['username']);
    }

    public static function isAdmin(): bool
    {
        return self::isAuthenticated() && isset($_SESSION['admin']) && $_SESSION['admin'];
    }

    public static function setFlash($type, $message): void
    {
        $_SESSION['flash'] = [
            'type' => $type,
            'message' => $message
        ];
    }

}